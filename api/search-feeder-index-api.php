<?php
    session_start();
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection-variable.php");

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
        define('intType', array(
            "all"=>">= 0",
            "sustain"=>"> 1",
            "momentary"=>"<= 1"
        ));
        // $causes = json_decode(file_get_contents('http://localhost/reliabilityweb/api/fetch-cause-api.php'), true);
        // var_dump(array_keys($causes));
    }
    // /.***** constant variable *****
        
    // Get variable from request
        (isset($_GET['feederName'])) ? $feederName = $_GET['feederName'] : null;
        (isset($_GET['selectedDistValue'])) ? $selectedDistValue = (int)$_GET['selectedDistValue'] : null;
        (isset($_GET['selectedCause'])) ? $selectedCause = $_GET['selectedCause'] : null;
        $outageSystem = $_GET['outageSystem'];
        $intType = $_GET['intType'];
        $dateFrom = $_GET['dateFrom'];
        $dateTo = $_GET['dateTo'];
    // /.Get variable from request

    //ชื่อตาราง
    $table = 'fdr_outage';//'fdr_outage_view';//
    //ชื่อคีย์หลัก
    $primaryKey =  'fdr_outage_id';//'num';//
    //ข้อมูลอะเรที่ส่งป datables
    $columns = array(
        array(  'db' => 'event_date', 'dt' => 0),
        array(  'db' => 'feeder', 'dt' => 1 ),
        array(  'db' => 'time_from', 'dt' => 2 ),
        array(  'db' => 'time_to', 'dt' => 3 ),
        array(  'db' => 'timeocb', 'dt' => 4),
        array(  'db' => 't_cause', 'dt' => 5),
        array(  'db' => 't_component', 'dt' => 6),
        array(  'db' => 'group_type', 'dt' => 7),
        array(  'db' => 'relay_show', 'dt' => 8),
        array(  'db' => 'pole', 'dt' => 9),
        array(  'db' => 'road', 'dt' => 10),
        array(  'db' => 'lateral', 'dt' => 11),
    );
    //เชื่อต่อฐานข้อมูล
    $sql_details = array(
        'user' => $db_user,
        'pass' => $db_password,
        'db'   => $db_name,
        'host' => $db_host
    );
    // เรียกใช้ไฟล์ spp.class.php
    require( '../ssp.class.php' );
    //ส่งข้อมูลกลับไปเป็น JSON โดยข้อมูลถูกดึงมาจากการเรียกใช้ class ssp
    $whereAll = "";
    if (isset($feederName)) {
        $whereAll = "feeder LIKE '$feederName%' AND ";
    } else {
        ($selectedDistValue !== 0) ? $whereAll = "district = $selectedDistValue AND " : null;
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
        group_type IN($outageSystem) 
        AND timeocb ".intType[$intType]." 
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