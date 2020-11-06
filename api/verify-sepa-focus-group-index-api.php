<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // ***** constant variable *****
    {
        define('sepaFocusHasTarget', [
            2018 => true,
            2019 => true,
            2020 => true
        ]); // true has target, false hasn't target
    }
    // /.***** constant variable *****
    
    // ***** get variable from requesting *****
    {
        $selectedYear = $_GET['selectedYear'];
    }
    // /.***** get variable from requesting *****

    // ***** declare variable *****
    {
        $accuMeaCust = array();
        $eachMeaCust = array();
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();

        $saifiMTarget = array();
        $saifiLSTarget = array();
        $saifiFTarget = array();
        $saidiMTarget = array();
        $saidiLSTarget = array();
        $saidiFTarget = array();

        $saifiMKpi = array();
        $saifiLSKpi = array();
        $saifiFKpi = array();
        $saidiMKpi = array();
        $saidiLSKpi = array();
        $saidiFKpi = array();

        $saifiMPrevious = array();
        $saidiMPrevious = array();
        $saifiMonthMPrevious = array();
        $saidiMonthMPrevious = array();
        $saifiLSPrevious = array();
        $saidiLSPrevious = array();
        $saifiMonthLSPrevious = array();
        $saidiMonthLSPrevious = array();
        $saifiFPrevious = array();
        $saidiFPrevious = array();
        $saifiMonthFPrevious = array();
        $saidiMonthFPrevious = array();

        $saifiM = array();
        $saidiM = array();
        $saifiMonthM = array();
        $saidiMonthM = array();
        $saifiLS = array();
        $saidiLS = array();
        $saifiMonthLS = array();
        $saidiMonthLS = array();
        $saifiF = array();
        $saidiF = array();
        $saifiMonthF = array();
        $saidiMonthF = array();
    }
    // /.***** declare variable *****
    
    // MEA SEPA Focus Group Target or MEA Indices Previous Year
    {
        // MEA SEPA Focus Group Target
        if (sepaFocusHasTarget[$selectedYear]) { //sepaFocusHasTarget[$selectedYear]

            $sql = 'SELECT
                        *
                    FROM
                        target_mea_sepa_focus_group
                    WHERE
                        year(yearmonthnumbertarget) = '.$selectedYear;

            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // saifi MEA Target
                $saifiMTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_MEATarget_1'];
                $saifiMTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_MEATarget_2'];
                $saifiMTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_MEATarget_3'];
                $saifiMTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_MEATarget_4'];
                $saifiMTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_MEATarget_5'];
                // saidi MEA Target
                $saidiMTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_MEATarget_1'];
                $saidiMTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_MEATarget_2'];
                $saidiMTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_MEATarget_3'];
                $saidiMTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_MEATarget_4'];
                $saidiMTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_MEATarget_5'];

                // saifi Line&Station Target
                $saifiLSTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_LSTarget_1'];
                $saifiLSTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_LSTarget_2'];
                $saifiLSTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_LSTarget_3'];
                $saifiLSTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_LSTarget_4'];
                $saifiLSTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_LSTarget_5'];
                // saidi Line&Station Target
                $saidiLSTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_LSTarget_1'];
                $saidiLSTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_LSTarget_2'];
                $saidiLSTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_LSTarget_3'];
                $saidiLSTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_LSTarget_4'];
                $saidiLSTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_LSTarget_5'];

                // saifi Feeder Target
                $saifiFTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_DistTarget_1'];
                $saifiFTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_DistTarget_2'];
                $saifiFTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_DistTarget_3'];
                $saifiFTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_DistTarget_4'];
                $saifiFTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_DistTarget_5'];
                // saidi Feeder Target
                $saidiFTarget[1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_DistTarget_1'];
                $saidiFTarget[2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_DistTarget_2'];
                $saidiFTarget[3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_DistTarget_3'];
                $saidiFTarget[4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_DistTarget_4'];
                $saidiFTarget[5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_DistTarget_5'];
            }
            
            // Create Array Response
            $res['saifiMTarget'] = $saifiMTarget;
            $res['saidiMTarget'] = $saidiMTarget;
            $res['saifiLSTarget'] = $saifiLSTarget;
            $res['saidiLSTarget'] = $saidiLSTarget;
            $res['saifiFTarget'] = $saifiFTarget;
            $res['saidiFTarget'] = $saidiFTarget;

        } else { // MEA Indices Previous Year
            $previousYear = $selectedYear-1;

            // MEA Focus Group Customer Previous Year
            {
                $sql = 'SELECT 
                            month AS no_month, 
                            sum(nocus) AS mea_cust 
                        FROM 
                            discust 
                        WHERE 
                            district in (
                                SELECT 
                                    code 
                                FROM 
                                    focusdist 
                                WHERE 
                                    year = '.$selectedYear.') 
                            AND year = '.$previousYear.' 
                        GROUP BY 
                            month';
    
                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $accuMeaCust[$row['no_month']] = (float)$row['mea_cust'] + ($row['no_month'] == "1" ? 0 : (float)$accuMeaCust[(int)$row['no_month']-1]);
                    $eachMeaCust[$row['no_month']] = (float)$row['mea_cust'];
                }
            }

            // MEA SEPA Focus Group Previous Year
            {
                $sql = 'SELECT 
                            month(date) AS no_month, 
                            sum(cust_num) AS cust_num_month, 
                            sum(cust_min) AS cust_min_month 
                        FROM 
                            indices_db 
                        WHERE 
                            timeocb > 1 
                            AND event in("I", "O") 
                            AND major is null 
                            AND year(date) = '.$previousYear.' 
                            AND control = "C" 
                            AND custdist in ( 
                                SELECT 
                                    code 
                                FROM 
                                    focusdist 
                                WHERE 
                                    year = '.$selectedYear.') 
                        GROUP BY 
                            month(date)';
    
                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }
                
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row);
                [$saifiMPrevious, $saidiMPrevious] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
                [$saifiMonthMPrevious, $saidiMonthMPrevious] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
                
                // Create Array Response
                $res['saifiMPrevious'] = $saifiMPrevious;
                $res['saidiMPrevious'] = $saidiMPrevious;
                $res['saifiMonthMPrevious'] = $saifiMonthMPrevious;
                $res['saidiMonthMPrevious'] = $saidiMonthMPrevious;
            }

            // Transmission Line and Station SEPA Focus Group Previous Year
            {
                $sql = 'SELECT 
                            month(date) AS no_month, 
                            sum(cust_num) AS cust_num_month, 
                            sum(cust_min) AS cust_min_month
                        FROM 
                            indices_db 
                        WHERE 
                            timeocb > 1 
                            AND event in("I", "O") 
                            AND major is null 
                            AND year(date) = '.$previousYear.' 
                            AND group_type in("L", "S") 
                            AND control = "C" 
                            AND custdist in ( 
                                SELECT 
                                    code 
                                FROM 
                                    focusdist 
                                WHERE 
                                    year = '.$selectedYear.') 
                        GROUP BY 
                            month(date)';

                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }

                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row);
                [$saifiLSPrevious, $saidiLSPrevious] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
                [$saifiMonthLSPrevious, $saidiMonthLSPrevious] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
                
                // Create Array Response
                $res['saifiLSPrevious'] = $saifiLSPrevious;
                $res['saidiLSPrevious'] = $saidiLSPrevious;
                $res['saifiMonthLSPrevious'] = $saifiMonthLSPrevious;
                $res['saidiMonthLSPrevious'] = $saidiMonthLSPrevious;
            }

            // Feeder Previous Year
            {
                $sql = 'SELECT 
                            month(date) AS no_month, 
                            sum(cust_num) AS cust_num_month, 
                            sum(cust_min) AS cust_min_month
                        FROM 
                            indices_db 
                        WHERE 
                            timeocb > 1 
                            AND event in("I", "O") 
                            AND major is null 
                            AND year(date) = '.$previousYear.' 
                            AND group_type in("F") 
                            AND control = "C" 
                            AND custdist in ( 
                                SELECT 
                                    code 
                                FROM 
                                    focusdist 
                                WHERE 
                                    year = '.$selectedYear.') 
                        GROUP BY 
                            month(date)';

                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }

                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row);
                [$saifiFPrevious, $saidiFPrevious] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
                [$saifiMonthFPrevious, $saidiMonthFPrevious] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
                
                // Create Array Response
                $res['saifiFPrevious'] = $saifiFPrevious;
                $res['saidiFPrevious'] = $saidiFPrevious;
                $res['saifiMonthFPrevious'] = $saifiMonthFPrevious;
                $res['saidiMonthFPrevious'] = $saidiMonthFPrevious;
            }
        }
    }
    // /.MEA SEPA Focus Group Target or MEA Indices Previous Year

    // check lasted month of indices_db table
    {
        // lasted_month
        $sql = 'SELECT  
                    month(date) AS lasted_month, 
                    day(date) AS lasted_day 
                FROM
                    indices_db_15days 
                WHERE
                    year(date) = '.$selectedYear.'
                ORDER BY 
                    date DESC 
                LIMIT 1';

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lastedMonth = $row[0]["lasted_month"];
        $lastedDay = $row[0]["lasted_day"];
        
        $previousMonth = (string)((int)$lastedMonth - 1);
    }
    // /.check lasted year and lasted month of indices_db table

    // ***** CALCULATE INDICES *****
    // Check as half month or full month unoffcial data
    {
        if ((int)$lastedDay < 28) {
            $halfMonth = true;
        } else {
            $halfMonth = false;
        }
    }
    // /.Check as half month or full month unoffcial data

    // MEA Focus Group Customer
    {
        $queryMonth = ($halfMonth) ? $previousMonth : $lastedMonth;
        $sql = 'SELECT 
                    month AS no_month, 
                    sum(nocus) AS mea_cust_month
                FROM 
                    discust 
                WHERE 
                    district in (
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.') 
                    AND year = '.$selectedYear.' 
                    AND month <= '.$queryMonth.' 
                    GROUP BY 
                        month';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        // remove member in array
        $accuMeaCust = array();
        $eachMeaCust = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accuMeaCust[$row['no_month']] = (float)$row['mea_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuMeaCust[(int)$row['no_month']-1]);
            $eachMeaCust[$row['no_month']] = (float)$row['mea_cust_month'];
        }

        if ($halfMonth) {
            $accuMeaCust[] = $accuMeaCust[count($accuMeaCust)] + $eachMeaCust[count($eachMeaCust)];
            $eachMeaCust[] = $eachMeaCust[count($eachMeaCust)];
        }
    }
    // /.MEA Focus Group Customer

    // MEA SEPA Focus Group
    {
        // query official data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) <= '.$previousMonth.' 
                    AND control = "C" 
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.') 
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // query official data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db_15days 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) = '.$lastedMonth.' 
                    AND control = "C" 
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.') 
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $rowUnofficial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $row = array_merge($row, $rowUnofficial);
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, (int)$lastedMonth);
        [$saifiM, $saidiM] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
        [$saifiMonthM, $saidiMonthM] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
        if (sepaFocusHasTarget[$selectedYear]) {
            [$saifiMKpi, $saidiMKpi] = calculateKPI($saifiM, $saidiM, $saifiMTarget, $saidiMTarget, "m");
        } else {
            [$saifiMKpi, $saidiMKpi] = calculateComparePreviousYear($saifiM, $saidiM, $saifiMPrevious, $saidiMPrevious);
        }

        // Create Array Response
        $res['saifiM'] = $saifiM;
        $res['saidiM'] = $saidiM;
        $res['saifiMonthM'] = $saifiMonthM;
        $res['saidiMonthM'] = $saidiMonthM;
        $res['saifiMKpi'] = $saifiMKpi;
        $res['saidiMKpi'] = $saidiMKpi;
    }
    // /.MEA SEPA Focus Group

    // Transmission Line and Station SEPA Focus Group
    {
        // query official data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) <= '.$previousMonth.' 
                    AND group_type in("L", "S") 
                    AND control = "C"
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.')  
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // query unofficial data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db_15days 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) = '.$lastedMonth.' 
                    AND group_type in("L", "S") 
                    AND control = "C"
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.')  
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $rowUnofficial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $row = array_merge($row, $rowUnofficial);
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, (int)$lastedMonth);
        [$saifiLS, $saidiLS] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
        [$saifiMonthLS, $saidiMonthLS] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
        if (sepaFocusHasTarget[$selectedYear]) {
            [$saifiLSKpi, $saidiLSKpi] = calculateKPI($saifiLS, $saidiLS, $saifiLSTarget, $saidiLSTarget, "ls");
        } else {
            [$saifiLSKpi, $saidiLSKpi] = calculateComparePreviousYear($saifiLS, $saidiLS, $saifiLSPrevious, $saidiLSPrevious);
        }

        // Create Array Response
        $res['saifiLS'] = $saifiLS;
        $res['saidiLS'] = $saidiLS;
        $res['saifiMonthLS'] = $saifiMonthLS;
        $res['saidiMonthLS'] = $saidiMonthLS;
        $res['saifiLSKpi'] = $saifiLSKpi;
        $res['saidiLSKpi'] = $saidiLSKpi;
    }
    // /.Transmission Line and Station SEPA Focus Group

    // Feeder SEPA Focus Group
    {
        // query official data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) <= '.$previousMonth.' 
                    AND group_type in("F") 
                    AND control = "C" 
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.') 
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // query official data
        $sql = 'SELECT 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db_15days 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) = '.$lastedMonth.' 
                    AND group_type in("F") 
                    AND control = "C" 
                    AND custdist in ( 
                        SELECT 
                            code 
                        FROM 
                            focusdist 
                        WHERE 
                            year = '.$selectedYear.') 
                GROUP BY
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $rowUnofficial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $row = array_merge($row, $rowUnofficial);
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, (int)$lastedMonth);
        [$saifiF, $saidiF] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust);
        [$saifiMonthF, $saidiMonthF] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust);
        if (sepaFocusHasTarget[$selectedYear]) {
            [$saifiFKpi, $saidiFKpi] = calculateKPI($saifiF, $saidiF, $saifiFTarget, $saidiFTarget, "f");
        } else {
            [$saifiFKpi, $saidiFKpi] = calculateComparePreviousYear($saifiF, $saidiF, $saifiFPrevious, $saidiFPrevious);
        }
        
        // Create Array Response
        $res['saifiF'] = $saifiF;
        $res['saidiF'] = $saidiF;
        $res['saifiMonthF'] = $saifiMonthF;
        $res['saidiMonthF'] = $saidiMonthF;
        $res['saifiFKpi'] = $saifiFKpi;
        $res['saidiFKpi'] = $saidiFKpi;
    }
    // /.Feeder SEPA Focus Group

    // Create Array Response
    {
        $res['lasted_year'] = $selectedYear;
        $res['lasted_month'] = $lastedMonth;
        $res['sepaFocusHasTarget'] = sepaFocusHasTarget[$selectedYear];
        $res['halfMonth'] = $halfMonth;
    }

    // Create and Send Json Response
    {
        $jsonRes = json_encode($res);
        echo $jsonRes;
    }

    // close connection
    $db = null;

    // ***** UTILITIES FUNCTION *****
    // Calculate Accumulative Indices
    function calculateAccuIndices($accuCustNum, $accuCustMin, $accuMeaCust) {
        for ($i=1; $i <= count($accuMeaCust); $i++) { 
            $saifi[$i] = round($accuCustNum[$i]/$accuMeaCust[$i]*$i, 3);
            $saidi[$i] = round($accuCustMin[$i]/$accuMeaCust[$i]*$i, 3);
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Accumulative Indices

    // Calculate Each Month Indices
    function calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachMeaCust) {
        for ($i=1; $i <= count($eachMeaCust); $i++) { 
            $saifi[$i] = round($eachCustNum[$i]/$eachMeaCust[$i], 3);
            $saidi[$i] = round($eachCustMin[$i]/$eachMeaCust[$i], 3);
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Each Month Indices

    // Calculate KPI
    function calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget, $system) {

        if ($system != 'e') { // for mea, line&station, feeder
            for ($key=1; $key <= count($saifi); $key++) { 
                switch ($saifi[$key]) {
                    case ($saifi[$key] <= $saifiTarget[5][$key]):
                        $saifi_kpi[$key] = 5.00;
                        break;
                        
                    case ($saifi[$key] <= $saifiTarget[4][$key]):
                        $saifi_kpi[$key] = round( ($saifi[$key] - $saifiTarget[4][$key]) / ($saifiTarget[5][$key] - $saifiTarget[4][$key]) + 4, 2);
                        break;

                    case ($saifi[$key] <= $saifiTarget[3][$key]):
                        $saifi_kpi[$key] = round( ($saifi[$key] - $saifiTarget[3][$key]) / ($saifiTarget[4][$key] - $saifiTarget[3][$key]) + 3, 2);
                        break;
                    
                    case ($saifi[$key] <= $saifiTarget[2][$key]):
                        $saifi_kpi[$key] = round( ($saifi[$key] - $saifiTarget[2][$key]) / ($saifiTarget[3][$key] - $saifiTarget[2][$key]) + 2, 2);
                        break;
                    
                    case ($saifi[$key] <= $saifiTarget[1][$key]):
                        $saifi_kpi[$key] = round( ($saifi[$key] - $saifiTarget[1][$key]) / ($saifiTarget[2][$key] - $saifiTarget[1][$key]) + 1, 2);
                        break;
                    
                    case ($saifi[$key] > $saifiTarget[1][$key]):
                        $saifi_kpi[$key] = 1.00;
                        break;
                    default:
                        break;
                }

                switch ($saidi[$key]) {
                    case ($saidi[$key] <= $saidiTarget[5][$key]):
                        $saidi_kpi[$key] = 5.00;
                        break;
                        
                    case ($saidi[$key] <= $saidiTarget[4][$key]):
                        $saidi_kpi[$key] = round( ($saidi[$key] - $saidiTarget[4][$key]) / ($saidiTarget[5][$key] - $saidiTarget[4][$key]) + 4, 2);
                        break;

                    case ($saidi[$key] <= $saidiTarget[3][$key]):
                        $saidi_kpi[$key] = round( ($saidi[$key] - $saidiTarget[3][$key]) / ($saidiTarget[4][$key] - $saidiTarget[3][$key]) + 3, 2);
                        break;
                    
                    case ($saidi[$key] <= $saidiTarget[2][$key]):
                        $saidi_kpi[$key] = round( ($saidi[$key] - $saidiTarget[2][$key]) / ($saidiTarget[3][$key] - $saidiTarget[2][$key]) + 2, 2);
                        break;
                    
                    case ($saidi[$key] <= $saidiTarget[1][$key]):
                        $saidi_kpi[$key] = round( ($saidi[$key] - $saidiTarget[1][$key]) / ($saidiTarget[2][$key] - $saidiTarget[1][$key]) + 1, 2);
                        break;
                    
                    case ($saidi[$key] > $saidiTarget[1][$key]):
                        $saidi_kpi[$key] = 1.00;
                        break;
                    default:
                        break;
                }
            }       
        } else { // for egat
            for ($key=1; $key <= count($saifi) ; $key++) { 
                if ($saifi[$key] <= $saifiTarget[$key]) {
                    $saifi_kpi[$key] = "good";
                } else {
                    $saifi_kpi[$key] = "bad";
                }

                if ($saidi[$key] <= $saidiTarget[$key]) {
                    $saidi_kpi[$key] = "good";
                } else {
                    $saidi_kpi[$key] = "bad";
                }
            }    
        }

        return [$saifi_kpi, $saidi_kpi];
    }
    // /.Calculate KPI

    // Calculate compare with previous year
    function calculateComparePreviousYear($saifi, $saidi, $saifiPrevious, $saidiPrevious) {
        for ($key=1; $key <= count($saifi) ; $key++) { 
            if ($saifiPrevious[$key] != 0) {
                $saifiComparePY[$key] = round( ($saifi[$key] - $saifiPrevious[$key]) / $saifiPrevious[$key] * 100, 2);
                // if (is_nan($saifiComparePY[$key]) || is_infinite($saifiComparePY[$key])) {
                //     $saifiComparePY[$key] = '-';
                // }
            } else {
                $saifiComparePY[$key] = ($saifi[$key]>0) ? 100 : -100 ;
            }
            if ($saidiPrevious[$key] != 0) {
                $saidiComparePY[$key] = round( ($saidi[$key] - $saidiPrevious[$key]) / $saidiPrevious[$key] * 100, 2);
                // if (is_nan($saidiComparePY[$key]) || is_infinite($saidiComparePY[$key])) {
                //     $saidiComparePY[$key] = '-';
                // }
            } else {
                $saidiComparePY[$key] = ($saifi[$key]>0) ? 100 : -100 ;
            }
        }

        return [$saifiComparePY, $saidiComparePY];
    }
    // /.Calculate compare with previous year

    // fectch PDO object to variable
    function fetchCustNumMin($row, $no_month=12) {        
        $accuCustNum = array(0);
        $eachCustNum = array(0);
        $accuCustMin = array(0);
        $eachCustMin = array(0);
        
        $x = 0; // count for index $row
        for ($i = 1; $i <= $no_month; $i++) {
            if (isset($row[$x]) && $row[$x]['no_month'] == $i) {
                $accuCustNum[$i] = (float)$row[$x]['cust_num_month'] + (float)$accuCustNum[$i-1];
                $eachCustNum[$i] = (float)$row[$x]['cust_num_month'];
                $accuCustMin[$i] = (float)$row[$x]['cust_min_month'] + (float)$accuCustMin[$i-1];
                $eachCustMin[$i] = (float)$row[$x]['cust_min_month'];
                $x++;                                                            
            } else {
                $accuCustNum[$i] = $accuCustNum[$i-1];
                $eachCustNum[$i] = 0.00;
                $accuCustMin[$i] = $accuCustMin[$i-1];
                $eachCustMin[$i] = 0.00;
            }       
        }
        
        return array($accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin);
    }
    // /fectch PDO object to variable
?>