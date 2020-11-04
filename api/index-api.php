<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // ***** constant variable *****
    {
        define('strategyTarget', [
            2016 => true,
            2017 => true,
            2018 => true,
            2019 => false,
            2020 => true
        ]); // true has target, false hasn't target
    }
    // /.***** constant variable *****
    
    // check lasted year and lasted month of indices_db table
    {
        // lasted_year
        $sql = 'SELECT 
                    max(year(date)) AS lasted_year
                FROM
                    indices_db';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lastedYear = $row[0]["lasted_year"];

        // lasted_month
        $sql = 'SELECT  
                    max(month(date)) AS lasted_month
                FROM
                    indices_db
                WHERE
                    year(date) = '.$lastedYear;

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lastedMonth = $row[0]["lasted_month"];
    }
    // /.check lasted year and lasted month of indices_db table

    // MEA Customer
    {
        $sql = 'SELECT 
                    max(month) AS no_month, 
                    sum(nocus) AS mea_cust 
                FROM 
                    discust 
                WHERE 
                    district = 99 
                    AND year = '.$lastedYear.' 
                    AND month <= '.$lastedMonth;
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['no_month'] = $row[0]['no_month'];
        $data['mea_cust'] = (float)$row[0]['mea_cust'];
    }
    // /.MEA Customer

    // MEA Strategy
    {
        $sql = 'SELECT 
                    max(month(date)) AS no_month,
                    sum(cust_num) AS cust_num_all, 
                    sum(cust_min) AS cust_min_all 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major is null 
                    AND year(date) = '.$lastedYear;
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['cust_num_all'] = (float)$row[0]['cust_num_all'];
        $data['cust_min_all'] = (float)$row[0]['cust_min_all'];
    }
    // /.MEA Strategy

    // MEA Strategy Target or MEA Indices Previous Year
    {
        // MEA Strategy Target
        if (strategyTarget[$lastedYear]) { //strategyTarget[$lastedYear]
            $sql = 'SELECT 
                        month(YearMonthnumberTarget) AS no_month, 
                        SAIFI_MEATarget_5, 
                        SAIFI_MEATarget_4, 
                        SAIFI_MEATarget_3, 
                        SAIFI_MEATarget_2, 
                        SAIFI_MEATarget_1, 
                        SAIDI_MEATarget_5, 
                        SAIDI_MEATarget_4, 
                        SAIDI_MEATarget_3, 
                        SAIDI_MEATarget_2, 
                        SAIDI_MEATarget_1 
                    FROM 
                        target 
                    WHERE 
                        month(yearmonthnumbertarget) = '.$data['no_month'].' 
                        AND year(yearmonthnumbertarget) = '.$lastedYear;
    
            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data['SAIFI_MEATarget'] = [(float)$row[0]['SAIFI_MEATarget_5'], (float)$row[0]['SAIFI_MEATarget_4'], (float)$row[0]['SAIFI_MEATarget_3'], (float)$row[0]['SAIFI_MEATarget_2'], (float)$row[0]['SAIFI_MEATarget_1']];
            $data['SAIDI_MEATarget'] = [(float)$row[0]['SAIDI_MEATarget_5'], (float)$row[0]['SAIDI_MEATarget_4'], (float)$row[0]['SAIDI_MEATarget_3'], (float)$row[0]['SAIDI_MEATarget_2'], (float)$row[0]['SAIDI_MEATarget_1']];
        } else { // MEA Indices Previous Year
            $previousYear = $lastedYear-1;

            // MEA Customer Previous Year
            $sql = 'SELECT 
                        year, 
                        max(month) AS no_month, 
                        sum(nocus) AS mea_cust 
                    FROM 
                        discust 
                    WHERE 
                        district = 99 
                        AND month <= '.$data['no_month'].' 
                        AND year = '.$previousYear.' 
                        AND month <= '.$lastedMonth;

            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data['mea_cust_previous_year'] = (float)$row[0]['mea_cust'];

            // MEA Strategy Previous Year
            $sql = 'SELECT 
                        year(date) AS year, 
                        max(month(date)) AS no_month, 
                        sum(cust_num) AS cust_num_all, 
                        sum(cust_min) AS cust_min_all 
                    FROM 
                        indices_db 
                    WHERE 
                        timeocb > 1 
                        AND event in("I", "O") 
                        AND major is null 
                        AND year(date) = '.$previousYear.'
                        AND month(date) <= '.$data['no_month'];
            
            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $data['cust_num_all_previous_year'] = (float)$row[0]['cust_num_all'];
            $data['cust_min_all_previous_year'] = (float)$row[0]['cust_min_all'];
        }
    }
    // /.MEA Strategy Target

    // MEA SEPA
    {
        $sql = 'SELECT 
                    max(month(date)) AS no_month, 
                    sum(cust_num) AS cust_num_all, 
                    sum(cust_min) AS cust_min_all 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major is null 
                    AND year(date) = '.$lastedYear.' 
                    AND control = "C"';
    
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['cust_num_all_sepa'] = (float)$row[0]['cust_num_all'];
        $data['cust_min_all_sepa'] = (float)$row[0]['cust_min_all'];
    }
    // /.MEA SEPA

    // MEA SEPA Target
    {
        $sql = 'SELECT 
                    month(YearMonthnumberTarget) AS no_month, 
                    SAIFI_MEATarget_5, 
                    SAIFI_MEATarget_4, 
                    SAIFI_MEATarget_3, 
                    SAIFI_MEATarget_2, 
                    SAIFI_MEATarget_1, 
                    SAIDI_MEATarget_5, 
                    SAIDI_MEATarget_4, 
                    SAIDI_MEATarget_3, 
                    SAIDI_MEATarget_2, 
                    SAIDI_MEATarget_1 
                FROM 
                    target_mea_sepa 
                WHERE 
                    month(yearmonthnumbertarget) = '.$data['no_month'].' 
                    AND year(yearmonthnumbertarget) = '.$lastedYear;

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['SAIFI_MEATarget_sepa'] = [(float)$row[0]['SAIFI_MEATarget_5'], (float)$row[0]['SAIFI_MEATarget_4'], (float)$row[0]['SAIFI_MEATarget_3'], (float)$row[0]['SAIFI_MEATarget_2'], (float)$row[0]['SAIFI_MEATarget_1']];
        $data['SAIDI_MEATarget_sepa'] = [(float)$row[0]['SAIDI_MEATarget_5'], (float)$row[0]['SAIDI_MEATarget_4'], (float)$row[0]['SAIDI_MEATarget_3'], (float)$row[0]['SAIDI_MEATarget_2'], (float)$row[0]['SAIDI_MEATarget_1']];
    }
    // /.MEA SEPA Target

    // MEA SEPA Focus Group Customer
    {
        $sql = 'SELECT 
                    max(month) AS no_month, 
                    sum(nocus) AS focus_cust 
                FROM 
                    discust 
                WHERE 
                    year = '.$lastedYear.' 
                    AND month <= '.$lastedMonth.' 
                    AND district in (SELECT 
                                        code 
                                    FROM 
                                        focusdist 
                                    WHERE 
                                        year = '.$lastedYear.')';
    
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['focus_cust'] = (float)$row[0]['focus_cust'];
    }
    // /.MEA SEPA Focus Group Customer

    // MEA SEPA Focus Group
    {
        $sql = 'SELECT 
                    max(month(date)) AS no_month, 
                    sum(cust_num) AS cust_num_all, 
                    sum(cust_min) AS cust_min_all 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major is null 
                    AND year(date) = '.$lastedYear.' 
                    AND control = "C" 
                    AND custdist in (SELECT 
                                        code 
                                    FROM 
                                        focusdist 
                                    WHERE 
                                        year = '.$lastedYear.')';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['cust_num_all_focus'] = (float)$row[0]['cust_num_all'];
        $data['cust_min_all_focus'] = (float)$row[0]['cust_min_all'];
    }
    // /.MEA SEPA Focus Group

    // MEA SEPA Focus Group Target
    {
        $sql = 'SELECT 
                    month(YearMonthnumberTarget) AS no_month, 
                    SAIFI_MEATarget_5, 
                    SAIFI_MEATarget_4, 
                    SAIFI_MEATarget_3, 
                    SAIFI_MEATarget_2, 
                    SAIFI_MEATarget_1, 
                    SAIDI_MEATarget_5, 
                    SAIDI_MEATarget_4, 
                    SAIDI_MEATarget_3, 
                    SAIDI_MEATarget_2, 
                    SAIDI_MEATarget_1 
                FROM 
                    target_mea_sepa_focus_group 
                WHERE 
                    month(yearmonthnumbertarget) = '.$data['no_month'].' 
                    and year(yearmonthnumbertarget) = '.$lastedYear;

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $data['SAIFI_MEATarget_focus'] = [(float)$row[0]['SAIFI_MEATarget_5'], (float)$row[0]['SAIFI_MEATarget_4'], (float)$row[0]['SAIFI_MEATarget_3'], (float)$row[0]['SAIFI_MEATarget_2'], (float)$row[0]['SAIFI_MEATarget_1']];
        $data['SAIDI_MEATarget_focus'] = [(float)$row[0]['SAIDI_MEATarget_5'], (float)$row[0]['SAIDI_MEATarget_4'], (float)$row[0]['SAIDI_MEATarget_3'], (float)$row[0]['SAIDI_MEATarget_2'], (float)$row[0]['SAIDI_MEATarget_1']];
    }
    // /.MEA SEPA Focus Group Target

    // ****** CALCULATE INDICES *****
    // Create Array Response
    {
        $res['lasted_year'] = $lastedYear;
        $res['lasted_month'] = $lastedMonth;
        $res['strategyHasTarget'] = strategyTarget[$lastedYear];
    }

    // MEA Strategy Indices
    {
        // MEA Strategy Target
        if (strategyTarget[$lastedYear]) {
            $index_kpi = calculateIndexAndKpi($data['no_month'], $data['mea_cust'], $data['cust_num_all'], $data['cust_min_all'], $data['SAIFI_MEATarget'], $data['SAIDI_MEATarget']);
            $res['saifi'] = $index_kpi[0];
            $res['saidi'] = $index_kpi[1];
            $res['saifi_kpi'] = $index_kpi[2];
            $res['saidi_kpi'] = $index_kpi[3];
        } else { // Comapare with Previous Year
            $index_kpi = calculateIndexAndcomparePreviousYear($data['no_month'], $data['mea_cust'], $data['cust_num_all'], $data['cust_min_all'], $data['mea_cust_previous_year'], $data['cust_num_all_previous_year'], $data['cust_min_all_previous_year']);
            $res['saifi'] = $index_kpi[0];
            $res['saidi'] = $index_kpi[1];
            $res['saifi_kpi'] = $index_kpi[2];
            $res['saidi_kpi'] = $index_kpi[3];
        }
    }
    // /.MEA Strategy Indices

    // MEA SEPA Indices
    {
        $index_kpi = calculateIndexAndKpi($data['no_month'], $data['mea_cust'], $data['cust_num_all_sepa'], $data['cust_min_all_sepa'], $data['SAIFI_MEATarget_sepa'], $data['SAIDI_MEATarget_sepa']);
        $res['saifi_sepa'] = $index_kpi[0];
        $res['saidi_sepa'] = $index_kpi[1];
        $res['saifi_kpi_sepa'] = $index_kpi[2];
        $res['saidi_kpi_sepa'] = $index_kpi[3];
    }
    // /.MEA SEPA Indices

    // MEA SEPA Focus Group Indices
    {
        $index_kpi = calculateIndexAndKpi($data['no_month'], $data['focus_cust'], $data['cust_num_all_focus'], $data['cust_min_all_focus'], $data['SAIFI_MEATarget_focus'], $data['SAIDI_MEATarget_focus']);
        $res['saifi_focus'] = $index_kpi[0];
        $res['saidi_focus'] = $index_kpi[1];
        $res['saifi_kpi_focus'] = $index_kpi[2];
        $res['saidi_kpi_focus'] = $index_kpi[3];
    }    
    // /.MEA SEPA Focus Group Indices

    // Create and Send Json Response
    {
        $jsonRes = json_encode($res);
        echo $jsonRes;
    }

    // close connection
    $db = null;

    // ***** UTILITIES FUNCTION *****
    function calculateIndexAndKpi($no_month, $mea_cust, $cust_num, $cust_min, $saifi_target, $saidi_target) {
        // Index
        $saifi = round($cust_num/$mea_cust*$no_month, 3);
        $saidi = round($cust_min/$mea_cust*$no_month, 3);

        // KPI
            // SAIFI
        switch ($saifi) {
            case ($saifi <= round($saifi_target[0], 3)):
                $saifi_kpi= '5.00';
                break;
            
            case ($saifi <= round($saifi_target[1], 3)):
                $saifi_kpi= number_format( ($saifi - $saifi_target[1]) / ($saifi_target[0] - $saifi_target[1]) + 4, 2, '.', '');
                break;

            case ($saifi <= round($saifi_target[2], 3)):
                $saifi_kpi= number_format( ($saifi - $saifi_target[2]) / ($saifi_target[1] - $saifi_target[2]) + 3, 2, '.', '');
                break;

            case ($saifi <= round($saifi_target[3], 3)):
                $saifi_kpi= number_format( ($saifi - $saifi_target[3]) / ($saifi_target[2] - $saifi_target[3]) + 2, 2, '.', '');
                break;

            case ($saifi <= round($saifi_target[4], 3)):
                $saifi_kpi= number_format( ($saifi - $saifi_target[4]) / ($saifi_target[3] - $saifi_target[4]) + 1, 2, '.', '');
                break;
            
            case ($saifi > round($saifi_target[4], 3)):
                $saifi_kpi= '1.00';
                break;
            // default:
            //     # code...
            //     break;
        }
            // SAIDI
        switch ($saidi) {
            case ($saidi <= round($saidi_target[0], 3)):
                $saidi_kpi= '5.00';
                break;
            
            case ($saidi <= round($saidi_target[1], 3)):
                $saidi_kpi= number_format( ($saidi - $saidi_target[1]) / ($saidi_target[0] - $saidi_target[1]) + 4, 2, '.', '');
                break;

            case ($saidi <= round($saidi_target[2], 3)):
                $saidi_kpi= number_format( ($saidi - $saidi_target[2]) / ($saidi_target[1] - $saidi_target[2]) + 3, 2, '.', '');
                break;

            case ($saidi <= round($saidi_target[3], 3)):
                $saidi_kpi= number_format( ($saidi - $saidi_target[3]) / ($saidi_target[2] - $saidi_target[3]) + 2, 2, '.', '');
                break;

            case ($saidi <= round($saidi_target[4], 3)):
                $saidi_kpi= number_format( ($saidi - $saidi_target[4]) / ($saidi_target[3] - $saidi_target[4]) + 1, 2, '.', '');
                break;
            
            case ($saidi > round($saidi_target[4], 3)):
                $saidi_kpi= '1.00';
                break;
            // default:
            //     # code...
            //     break;
        }
        
        return [number_format($saifi, 3, '.', ''), number_format($saidi, 3, '.', ''), $saifi_kpi, $saidi_kpi];
    }

    function calculateIndexAndcomparePreviousYear($no_month, $mea_cust, $cust_num, $cust_min, $mea_cust_previous_year, $cust_num_previous_year, $cust_min_previous_year) {
        // Index this year
        $saifi = round($cust_num/$mea_cust*$no_month, 3);
        $saidi = round($cust_min/$mea_cust*$no_month, 3);

        // Index this previous year
        $saifi_previous_year = round($cust_num_previous_year/$mea_cust_previous_year*$no_month, 3);
        $saidi_previous_year = round($cust_min_previous_year/$mea_cust_previous_year*$no_month, 3);

        // KPI
            // SAIFI
            if ($saifi <= $saifi_previous_year) {
                $saifi_kpi = '5'; //5 is better than previous year
            } else {
                $saifi_kpi = '1'; //1 is worse than previous year
            }

            // SAIDI
            if ($saidi <= $saidi_previous_year) {
                $saidi_kpi = '5'; //5 is better than previous year
            } else {
                $saidi_kpi = '1'; //1 is worse than previous year
            }
        
        return [number_format($saifi, 3, '.', ''), number_format($saidi, 3, '.', ''), $saifi_kpi, $saidi_kpi];
    }
?>