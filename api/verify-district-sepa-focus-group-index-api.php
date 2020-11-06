<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // ***** constant variable *****
    {
        define('sepaFocusHasTarget', [
            2018 => true,
            2019 => false,
            2020 => false
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
        $accuDistCust = array();
        $eachDistCust = array();
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();

        $tabb = array();

        $saifiTarget = array();
        $saidiTarget = array();

        $saifiKpi = array();
        $saidiKpi = array();

        $saifiPrevious = array();
        $saifiMonthPrevious = array();
        $saidiPrevious = array();
        $saidiMonthPrevious = array();

        $saifi = array();
        $saifiMonth = array();
        $saidi = array();
        $saidiMonth = array();
    }
    // /.***** declare variable *****

    // district code
    {
        $sql = 'SELECT 
                    code, 
                    tabb 
                FROM 
                    focusdist 
                WHERE 
                    year = '.$selectedYear;
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tabb[$row['code']] = $row['tabb'];
        }
    }
    // /district code
    
    // District SEPA Target or District Indices Previous Year
    {
        // District SEPA Target
        if (sepaFocusHasTarget[$selectedYear]) { //sepaFocusHasTarget[$selectedYear]

            $sql = 'SELECT
                        *
                    FROM
                        eachdisttarget_focus_group
                    WHERE
                        year(yearmonthnumbertarget) = '.$selectedYear.' 
                        AND districtCode in(SELECT 
                                                code 
                                            FROM 
                                                focusdist 
                                            WHERE 
                                                year = '.$selectedYear.')';

            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // saifi Target
                $saifiTarget[$row['districtCode']][1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_Target_1'];
                $saifiTarget[$row['districtCode']][2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_Target_2'];
                $saifiTarget[$row['districtCode']][3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_Target_3'];
                $saifiTarget[$row['districtCode']][4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_Target_4'];
                $saifiTarget[$row['districtCode']][5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIFI_Target_5'];
                
                $saidiTarget[$row['districtCode']][1][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_Target_1'];
                $saidiTarget[$row['districtCode']][2][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_Target_2'];
                $saidiTarget[$row['districtCode']][3][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_Target_3'];
                $saidiTarget[$row['districtCode']][4][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_Target_4'];
                $saidiTarget[$row['districtCode']][5][date("n", strtotime($row['YearMonthnumberTarget']))] = (float)$row['SAIDI_Target_5'];
            }

            // Create Array Response
            $res['saifiTarget'] = $saifiTarget;
            $res['saidiTarget'] = $saidiTarget;

        } else { // District Indices Previous Year
            $previousYear = $selectedYear-1;

            // District Customer Previous Year
            {
                $sql = 'SELECT 
                            district,
                            month AS no_month, 
                            nocus AS dist_cust 
                        FROM 
                            discust 
                        WHERE 
                            district in(SELECT 
                                            code 
                                        FROM 
                                            focusdist 
                                        WHERE 
                                            year = '.$selectedYear.') 
                            AND year = '.$previousYear;
    
                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $accuDistCust[$row['district']][$row['no_month']] = (float)$row['dist_cust'] + ($row['no_month'] == "1" ? 0 : (float)$accuDistCust[$row['district']][(int)$row['no_month']-1]);
                    $eachDistCust[$row['district']][$row['no_month']] = (float)$row['dist_cust'];
                }
            }

            // District SEPA Previous Year
            {
                $sql = 'SELECT 
                            custdist, 
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
                            AND group_type = "F" 
                            AND control = "C" 
                            AND custdist in(SELECT 
                                                code 
                                            FROM 
                                                focusdist 
                                            WHERE year = '.$selectedYear.') 
                        GROUP BY 
                            custdist, 
                            month(date)';
    
                try {
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                } catch (PDOException $e) {
                    echo 'Something wrong!!! '.$e->getMessage();
                }
                
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, $tabb);
                [$saifiPrevious, $saidiPrevious] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust, $tabb);
                [$saifiMonthPrevious, $saidiMonthPrevious] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust, $tabb);

                // Create Array Response
                $res['saifiPrevious'] = $saifiPrevious;
                $res['saidiPrevious'] = $saidiPrevious;
                $res['saifiMonthPrevious'] = $saifiMonthPrevious;
                $res['saidiMonthPrevious'] = $saidiMonthPrevious;
            }
        }
    }
    // /.District SEPA Target or District Indices Previous Year

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

    // District Customer
    {
        $queryMonth = ($halfMonth) ? $previousMonth : $lastedMonth;
        $sql = 'SELECT 
                    district,
                    month AS no_month, 
                    nocus AS dist_cust 
                FROM 
                    discust 
                WHERE 
                    district in(SELECT 
                                    code 
                                FROM 
                                    focusdist 
                                WHERE 
                                    year = '.$selectedYear.') 
                    AND year = '.$selectedYear.'
                    AND month <= '.$queryMonth;
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        // remove member in array
        $accuDistCust = array();
        $eachDistCust = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accuDistCust[$row['district']][$row['no_month']] = (float)$row['dist_cust'] + ($row['no_month'] == "1" ? 0 : (float)$accuDistCust[$row['district']][(int)$row['no_month']-1]);
            $eachDistCust[$row['district']][$row['no_month']] = (float)$row['dist_cust'];
        }

        if ($halfMonth) {
            for ($i = 1; $i <= count($tabb); $i++) {
                $accuDistCust[$i][] = $accuDistCust[$i][count($accuDistCust[$i])] + $eachDistCust[$i][count($eachDistCust[$i])];
                $eachDistCust[$i][] = $eachDistCust[$i][count($eachDistCust[$i])];
            }
        }
    }
    // /.District Customer

    // District SEPA
    {
        // query official data
        $sql = 'SELECT 
                    custdist, 
                    month(date) AS no_month, 
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major is null 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) <= '.$previousMonth.' 
                    AND group_type = "F" 
                    AND control = "C" 
                    AND custdist in(SELECT 
                                        code 
                                    FROM 
                                        focusdist 
                                    WHERE year = '.$selectedYear.') 
                GROUP BY 
                    custdist, 
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $rowOffcial = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // query unofficial data
        $sql = 'SELECT 
                    custdist, 
                    month(date) AS no_month, 
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    indices_db_15days 
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major is null 
                    AND year(date) = '.$selectedYear.' 
                    AND month(date) = '.$lastedMonth.' 
                    AND group_type = "F" 
                    AND control = "C" 
                    AND custdist in(SELECT 
                                        code 
                                    FROM 
                                        focusdist 
                                    WHERE year = '.$selectedYear.') 
                GROUP BY 
                    custdist, 
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $rowUnofficial = $stmt->fetchAll(PDO::FETCH_ASSOC);
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMinUnofficial($rowOffcial, $rowUnofficial, (int)$lastedMonth, (int)$previousMonth);
        [$saifi, $saidi] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust, $tabb);
        [$saifiMonth, $saidiMonth] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust, $tabb);
        if (sepaFocusHasTarget[$selectedYear]) {
            [$saifiKpi, $saidiKpi] = calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget, $tabb);
        } else {
            [$saifiKpi, $saidiKpi] = calculateComparePreviousYear($saifi, $saidi, $saifiPrevious, $saidiPrevious, $tabb);
        }

        // Create Array Response
        $res['saifi'] = $saifi;
        $res['saidi'] = $saidi;
        $res['saifiMonth'] = $saifiMonth;
        $res['saidiMonth'] = $saidiMonth;
        $res['saifiKpi'] = $saifiKpi;
        $res['saidiKpi'] = $saidiKpi;
    }
    // /.District SEPA

    // Create Array Response
    {
        $res['lasted_year'] = $selectedYear;
        $res['lasted_month'] = $lastedMonth;
        $res['sepaHasTarget'] = sepaFocusHasTarget[$selectedYear];
        $res['tabb'] = $tabb;
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
    function calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust, $tabb) {
        foreach ($tabb as $d => $abb) { 
            for ($i=1; $i <= count($accuDistCust[$d]); $i++) { 
                $saifi[$d][$i] = round($accuCustNum[$d][$i]/$accuDistCust[$d][$i]*$i, 3);
                $saidi[$d][$i] = round($accuCustMin[$d][$i]/$accuDistCust[$d][$i]*$i, 3);
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Accumulative Indices

    // Calculate Each Month Indices
    function calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust, $tabb) {
        foreach ($tabb as $d => $abb) { 
            for ($i=1; $i <= count($eachDistCust[$d]); $i++) { 
                $saifi[$d][$i] = round($eachCustNum[$d][$i]/$eachDistCust[$d][$i], 3);
                $saidi[$d][$i] = round($eachCustMin[$d][$i]/$eachDistCust[$d][$i], 3);
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Each Month Indices

    // Calculate KPI
    function calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget, $tabb) {
        foreach ($tabb as $d => $abb) { 
            for ($i=1; $i <= count($saifi[$d]); $i++) { 
                if ($saifiTarget[$d][5][$i] != 0) {
                    $saifiKpi[$d][$i] = round( ($saifi[$d][$i] - $saifiTarget[$d][5][$i]) / $saifiTarget[$d][5][$i] * 100, 2);
                } else {
                    $saifiKpi[$d][$i] = $saifi[$d][$i] > 0 ? 100 : -100;
                }

                if ($saidiTarget[$d][5][$i] != 0) {
                    $saidiKpi[$d][$i] = round( ($saidi[$d][$i] - $saidiTarget[$d][5][$i]) / $saidiTarget[$d][5][$i] * 100, 2);
                } else {
                    $saidiKpi[$d][$i] = $saidi[$d][$i] > 0 ? 100 : -100;
                }
            }
        }

        return [$saifiKpi, $saidiKpi];
    }
    // /.Calculate KPI

    // Calculate compare with previous year
    function calculateComparePreviousYear($saifi, $saidi, $saifiPrevious, $saidiPrevious, $tabb) {
        foreach ($tabb as $d => $abb) { 
            for ($i=1; $i <= count($saifi[$d]); $i++) { 
                if ($saifiPrevious[$d][$i] != 0) {
                    $saifiComparePY[$d][$i] = round( ($saifi[$d][$i] - $saifiPrevious[$d][$i]) / $saifiPrevious[$d][$i] * 100, 2);
                } else {
                    $saifiComparePY[$d][$i] = $saifi[$d][$i] > 0 ? 100 : -100;
                }

                if ($saidiPrevious[$d][$i] != 0) {
                    $saidiComparePY[$d][$i] = round( ($saidi[$d][$i] - $saidiPrevious[$d][$i]) / $saidiPrevious[$d][$i] * 100, 2);
                } else {
                    $saidiComparePY[$d][$i] = $saidi[$d][$i] > 0 ? 100 : -100;
                }
            }
        }

        return [$saifiComparePY, $saidiComparePY];
    }
    // /.Calculate compare with previous year

    // fectch PDO object to variable
    function fetchCustNumMin($row, $tabb, $no_month=12) {        
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();
        
        $x = 0; // count for index $row
        foreach ($tabb as $d => $abb) { 
            for ($i = 1; $i <= $no_month; $i++) {
                if (isset($row[$x]) && $row[$x]['custdist'] == $d && $row[$x]['no_month'] == $i) {
                    $accuCustNum[$d][$i] = (float)$row[$x]['cust_num_month'] + ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                    $eachCustNum[$d][$i] = (float)$row[$x]['cust_num_month'];
                    $accuCustMin[$d][$i] = (float)$row[$x]['cust_min_month'] + ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                    $eachCustMin[$d][$i] = (float)$row[$x]['cust_min_month'];
                    $x++;                                                            
                } else {
                    $accuCustNum[$d][$i] = ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                    $eachCustNum[$d][$i] = 0.00;
                    $accuCustMin[$d][$i] = ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                    $eachCustMin[$d][$i] = 0.00;
                }       
            }
        }

        return array($accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin);
    }
    // /fectch PDO object to variable

    // fectch PDO object to variable (for unofficial)
    function fetchCustNumMinUnofficial($rowOffcial, $rowUnofficial, $lastedMonth, $previousMonth) {
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();

        $x = 0; // count for index $row
        $row = $rowOffcial;
        for ($d = 1; $d <= 18 ; $d++) { 
            for ($i = 1; $i <= $previousMonth; $i++) {
                if (isset($row[$x]) && $row[$x]['custdist'] == $d && $row[$x]['no_month'] == $i) {
                    $accuCustNum[$d][$i] = (float)$row[$x]['cust_num_month'] + ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                    $eachCustNum[$d][$i] = (float)$row[$x]['cust_num_month'];
                    $accuCustMin[$d][$i] = (float)$row[$x]['cust_min_month'] + ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                    $eachCustMin[$d][$i] = (float)$row[$x]['cust_min_month'];
                    $x++;                                                            
                } else {
                    $accuCustNum[$d][$i] = ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                    $eachCustNum[$d][$i] = 0.00;
                    $accuCustMin[$d][$i] = ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                    $eachCustMin[$d][$i] = 0.00;
                }       
            }
        }

        $row = $rowUnofficial;
        $x = 0; // count for index $row
        $i = $lastedMonth;
        for ($d = 1; $d <= 18 ; $d++) { 
            if (isset($row[$x]) && $row[$x]['custdist'] == $d && $row[$x]['no_month'] == $i) {
                $accuCustNum[$d][$i] = (float)$row[$x]['cust_num_month'] + ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                $eachCustNum[$d][$i] = (float)$row[$x]['cust_num_month'];
                $accuCustMin[$d][$i] = (float)$row[$x]['cust_min_month'] + ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                $eachCustMin[$d][$i] = (float)$row[$x]['cust_min_month'];
                $x++;                                                            
            } else {
                $accuCustNum[$d][$i] = ($i-1 == 0 ? 0 : $accuCustNum[$d][$i-1]);
                $eachCustNum[$d][$i] = 0.00;
                $accuCustMin[$d][$i] = ($i-1 == 0 ? 0 : $accuCustMin[$d][$i-1]);
                $eachCustMin[$d][$i] = 0.00;
            }
        }

        return array($accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin);
    }
    // /fectch PDO object to variable (for unofficial)
?>