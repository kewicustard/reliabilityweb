<?php
    session_start();
    date_default_timezone_set('Asia/Bangkok');

    // ***** constant variable *****
    {
        define('thai_day_arr', array("อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัสบดี", "ศุกร์", "เสาร์"));
        define('thai_month_arr', array(
            "1"=>"ม.ค.",
            "2"=>"ก.พ.",
            "3"=>"มี.ค.",
            "4"=>"เม.ย.",
            "5"=>"พ.ค.",
            "6"=>"มิ.ย.", 
            "7"=>"ก.ค.",
            "8"=>"ส.ค.",
            "9"=>"ก.ย.",
            "10"=>"ต.ค.",
            "11"=>"พ.ย.",
            "12"=>"ธ.ค."                 
        ));
        define('intLineType', array(
            "all"=>">= 0",
            "sustain"=>">= 1",
            "momentary"=>"= 0"
        ));
        // $causes = json_decode(file_get_contents('http://localhost/reliabilityweb/api/fetch-cause-api.php'), true);
        // var_dump(array_keys($causes));
    }
    // /.***** constant variable *****
        
    // Get variable from request
        (isset($_GET['lineName'])) ? $lineName = $_GET['lineName'] : null;
        (isset($_GET['selectedCause'])) ? $selectedCause = $_GET['selectedCause'] : null;
        $intType = $_GET['intType'];
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
    // /.Get variable from request

    //ชื่อตาราง
    $table = 'lineoutage';//'fdr_outage_view';//
    //ชื่อคีย์หลัก
    $primaryKey =  'lineoutage_id';//'num';//
    //ข้อมูลอะเรที่ส่งป datables
    $columns = array(
        array(  'db' => 'event_date', 'dt' => 0),
        array(  'db' => 'line', 'dt' => 1 ),
        array(  'db' => 'time_from', 'dt' => 2 ),
        array(  'db' => 'time_to', 'dt' => 3 ),
        array(  'db' => 'timeocb', 'dt' => 4),
        array(  'db' => 't_cause', 'dt' => 5),
        array(  'db' => 't_component', 'dt' => 6),
        array(  'db' => 'relay_show', 'dt' => 7),
        array(  'db' => 'pole', 'dt' => 8),
        array(  'db' => 'road', 'dt' => 9),
        array(  'db' => 'lateral', 'dt' => 10),
        array(  'db' => 'affected_fdrs', 'dt' => 11),
        array(  'db' => 'fdr_minutes', 'dt' => 12),
    );
    //เชื่อต่อฐานข้อมูล
    $sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'statistics_database',
    'host' => 'localhost'
    );
    // เรียกใช้ไฟล์ spp.class.php
    require( '../ssp.class.php' );
    //ส่งข้อมูลกลับไปเป็น JSON โดยข้อมูลถูกดึงมาจากการเรียกใช้ class ssp
    $whereAll = "";
    if (isset($lineName)) {
        $whereAll = ($lineName !== 'allLine') ? "line LIKE '$lineName%' AND " : "";
    } else {
        // var_dump($selectedCause);
        if (in_array("000", $selectedCause)) {
            # code...
        } else {
            $mainSelectedCause = array_filter($selectedCause, fn($x) => substr($x, -1) === '0');
            $mainSelectedCause = array_map(fn($x) => substr($x, 0, 2).'_', $mainSelectedCause);
            $twoDigitMainSelectedCause = array_map(fn($x) => substr($x, 0, 2), $mainSelectedCause);
            $subSelectedCause = array_filter($selectedCause, fn($x) => !in_array(substr($x, 0, 2), $twoDigitMainSelectedCause));
            $whereAll .= "(";
            (count($mainSelectedCause) > 0) ? array_walk($mainSelectedCause, "generateQueryCause") : null;
            (count($subSelectedCause) > 0) ? $whereAll .= "sub_code IN ('".implode("','", $subSelectedCause)."')" : $whereAll = substr($whereAll, 0, -4);
            $whereAll .= ") AND ";
        }
    }
    $whereAll .= "
        sustain ".intLineType[$intType]." 
        AND event_date BETWEEN '$dateFrom' 
        AND '$dateTo'
    ";
    // var_dump($whereAll);
    $res = SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null, $whereAll );
    foreach ($res['data'] as $key => $value) {
        $res['data'][$key][0] = thai_date(strtotime($value[0]));
    }
    // count($res['data'])
    echo json_encode($res);

    // Utilities function
    {
        function thai_date($time) {
            return date("j", $time).' '.thai_month_arr[date("n", $time)].' '.strval(intval(date("Yํ", $time))); //strval(intval(date("Yํ", $time))+543
        }

        function generateQueryCause($mainCause) {
            global $whereAll;
            $whereAll .= "sub_code LIKE '$mainCause' OR ";          
        }
    }
    // /.Utilities function    
?>