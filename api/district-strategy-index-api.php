<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // ***** constant variable *****
    {
        define('strategyHasTarget', [
            2016 => true,
            2017 => true,
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
                    district 
                WHERE 
                    code BETWEEN 1 AND 18';
        
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
    
    // District Strategy Target or District Indices Previous Year
    {
        // District Strategy Target
        if (strategyHasTarget[$selectedYear]) { //strategyHasTarget[$selectedYear]

            $sql = 'SELECT
                        *
                    FROM
                        eachdisttarget
                    WHERE
                        year(yearmonthnumbertarget) = '.$selectedYear;

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
                            district != 99 
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

            // District Strategy Previous Year
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
                [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row);
                [$saifiPrevious, $saidiPrevious] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust);
                [$saifiMonthPrevious, $saidiMonthPrevious] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust);

                // Create Array Response
                $res['saifiPrevious'] = $saifiPrevious;
                $res['saidiPrevious'] = $saidiPrevious;
                $res['saifiMonthPrevious'] = $saifiMonthPrevious;
                $res['saidiMonthPrevious'] = $saidiMonthPrevious;
            }
        }
    }
    // /.District Strategy Target or District Indices Previous Year

    // check lasted month of indices_db table
    {
        // lasted_month
        $sql = 'SELECT  
                    max(month(date)) AS lasted_month
                FROM
                    indices_db
                WHERE
                    year(date) = '.$selectedYear;

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

    // ***** CALCULATE INDICES *****
    // District Customer
    {
        $sql = 'SELECT 
                    district,
                    month AS no_month, 
                    nocus AS dist_cust 
                FROM 
                    discust 
                WHERE 
                    district != 99 
                    AND year = '.$selectedYear.'
                    AND month <= '.$lastedMonth;
        
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
    }
    // /.District Customer

    // District Strategy
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
                    AND year(date) = '.$selectedYear.' 
                    AND group_type = "F" 
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
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, (int)$lastedMonth);
        [$saifi, $saidi] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust);
        [$saifiMonth, $saidiMonth] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust);
        if (strategyHasTarget[$selectedYear]) {
            [$saifiKpi, $saidiKpi] = calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget);
        } else {
            [$saifiKpi, $saidiKpi] = calculateComparePreviousYear($saifi, $saidi, $saifiPrevious, $saidiPrevious);
        }

        // Create Array Response
        $res['saifi'] = $saifi;
        $res['saidi'] = $saidi;
        $res['saifiMonth'] = $saifiMonth;
        $res['saidiMonth'] = $saidiMonth;
        $res['saifiKpi'] = $saifiKpi;
        $res['saidiKpi'] = $saidiKpi;
    }
    // /.District Strategy

    // Create Array Response
    {
        $res['lasted_year'] = $selectedYear;
        $res['lasted_month'] = $lastedMonth;
        $res['strategyHasTarget'] = strategyHasTarget[$selectedYear];
        $res['tabb'] = $tabb;
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
    function calculateAccuIndices($accuCustNum, $accuCustMin, $accuDistCust) {
        for ($d=1; $d <= count($accuDistCust) ; $d++) { 
            for ($i=1; $i <= count($accuDistCust[$d]); $i++) { 
                $saifi[$d][$i] = round($accuCustNum[$d][$i]/$accuDistCust[$d][$i]*$i, 3);
                $saidi[$d][$i] = round($accuCustMin[$d][$i]/$accuDistCust[$d][$i]*$i, 3);
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Accumulative Indices

    // Calculate Each Month Indices
    function calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachDistCust) {
        for ($d=1; $d <= count($eachDistCust) ; $d++) { 
            for ($i=1; $i <= count($eachDistCust[$d]); $i++) { 
                $saifi[$d][$i] = round($eachCustNum[$d][$i]/$eachDistCust[$d][$i], 3);
                $saidi[$d][$i] = round($eachCustMin[$d][$i]/$eachDistCust[$d][$i], 3);
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Each Month Indices

    // Calculate KPI
    function calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget) {
        for ($d=1; $d <= count($saifi) ; $d++) { 
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
    function calculateComparePreviousYear($saifi, $saidi, $saifiPrevious, $saidiPrevious) {
        for ($d=1; $d <= count($saifi) ; $d++) { 
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
    function fetchCustNumMin($row, $no_month=12) {        
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();
        
        $x = 0; // count for index $row
        for ($d = 1; $d <= 18 ; $d++) { 
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
?>