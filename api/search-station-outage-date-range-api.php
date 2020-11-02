<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");
    
    // Retrieve lasted and oldest date of outage_event_db
    {
        //lasted_date
        $sql = 'SELECT 
                    event_date AS lasted_date 
                FROM 
                    station_outage
                ORDER BY 
                    event_date DESC 
                LIMIT 1';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $res['lasted_date'] = $row[0]['lasted_date'];

        //oldest_date
        $sql = 'SELECT 
                    event_date AS oldest_date 
                FROM 
                    station_outage
                ORDER BY 
                    event_date ASC 
                LIMIT 1';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $res['oldest_date'] = $row[0]['oldest_date'];
    }

    // Create and Send Json Response
    {
        $jsonRes = json_encode($res);
        echo $jsonRes;
    }

    // close connection
    $db = null;
?>