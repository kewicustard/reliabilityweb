<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // fetch cause from database
    {
        // fetch main_cause
        $sql = 'SELECT 
                    code, 
                    t_main AS main_cause 
                FROM
                    nw_cause 
                GROUP BY
                    code';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $cause = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cause[$row['code']] = [
                'id'        =>  $row['code'],
                'text'      =>  $row['main_cause'],
                'children'  =>  [array(
                                    'id' => $row['code'],
                                    'text' => 'ทุกสาเหตุย่อยของ '.$row['main_cause'],
                                )]
            ];
        }

        // fetch sub_cause
        $sql = 'SELECT 
                    code, 
                    sub_code,  
                    t_cause AS sub_cause 
                FROM
                    nw_cause';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $cause[$row['code']]['children'][] = array(
                'id'        =>  $row['sub_code'],
                'text'      =>  $row['sub_cause'],
            );
        }
    }
    // /.fetch cause from database
    
    // Create and Send Json Response
    {
        $jsonRes = json_encode($cause);
        echo $jsonRes;
    }

    // close connection
    $db = null;

?>