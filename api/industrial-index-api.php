<?php
    session_start();
    
    header("Content-Type: application/json; charset=UTF-8");
    date_default_timezone_set('Asia/Bangkok');

    require_once("../connection.php");

    // ***** constant variable *****
    {
        define('industrialTarget', [
            2018 => true,
            2019 => true,
            2020 => true,
        ]); // true has target, false hasn't target

        define('industrialAbb', [
            'H', 'L', 'P', 'U', 'A', 'I'
        ]);

        define('industrialNotInYear', [
            2018 => ['A'],
        ]);
    }
    // /.***** constant variable *****
    
    // ***** get variable from requesting *****
    {
        $selectedYear = $_GET['selectedYear'];
    }
    // /.***** get variable from requesting *****

    // ***** declare variable *****
    {
        $accuICust = array();
        $eachICust = array();
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();

        $saifiTarget = array();
        $saidiTarget = array();

        $saifiKpi = array();
        $saidiKpi = array();

        $saifi = array();
        $saifiMonth = array();
        $saidi = array();
        $saidiMonth = array();
    }
    // /.***** declare variable *****
    
    // Industrail Service Standard Target(Threshold)
    {
        // Industrail Service Standard Target(Threshold)
        if (industrialTarget[$selectedYear]) { //industrialTarget[$selectedYear]

            $sql = 'SELECT
                        saifi_industrial, 
                        saidi_industrial 
                    FROM
                        service_standard 
                    WHERE
                    	Year_standard <= '.$selectedYear.'  
                    ORDER BY 
                        year_standard DESC
                    LIMIT 1';

            try {
                $stmt = $db->prepare($sql);
                $stmt->execute();
            } catch (PDOException $e) {
                echo 'Something wrong!!! '.$e->getMessage();
            }
            
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for ($i = 1; $i <= 12; $i++) {
                // saifi industrial threshold
                $saifiTarget[industrialAbb[5]][$i] = (float)$row[0]['saifi_industrial'];
                // saidi industrial threshold
                $saidiTarget[industrialAbb[5]][$i] = (float)$row[0]['saidi_industrial'];
            }
            
            // Create Array Response
            $res['saifiTarget'] = $saifiTarget;
            $res['saidiTarget'] = $saidiTarget;
        }
    }
    // /.Industrail Service Standard Target(Threshold)

    // check lasted month of area_cust table
    {
        // lasted_month
        $sql = 'SELECT  
                    max(month) AS lasted_month
                FROM
                    area_cust
                WHERE
                    year = '.$selectedYear;

        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $lastedMonth = $row[0]["lasted_month"];
        // print_r($lastedMonth);
    }
    // /.check lasted month of area_cust table

    // ***** CALCULATE INDICES *****
    // Industrial Customer
    {
        $sql = 'SELECT 
                    month AS no_month, 
                    bc_cus AS bc_cust_month, 
                    lb_cus AS lb_cust_month, 
                    bp_cus AS bp_cust_month, 
                    bu_cus AS bu_cust_month, 
                    as_cus AS as_cust_month, 
                    indust_cus AS indust_cust_month 
                FROM 
                    area_cust 
                WHERE 
                    year = '.$selectedYear.' 
                    AND month <= '.$lastedMonth;
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }

        // remove member in array
        $accuICust = array();
        $eachICust = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $accuICust[industrialAbb[0]][$row['no_month']] = (float)$row['bc_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[0]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[0]][$row['no_month']] = (float)$row['bc_cust_month'];
            $accuICust[industrialAbb[1]][$row['no_month']] = (float)$row['lb_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[1]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[1]][$row['no_month']] = (float)$row['lb_cust_month'];
            $accuICust[industrialAbb[2]][$row['no_month']] = (float)$row['bp_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[2]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[2]][$row['no_month']] = (float)$row['bp_cust_month'];
            $accuICust[industrialAbb[3]][$row['no_month']] = (float)$row['bu_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[3]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[3]][$row['no_month']] = (float)$row['bu_cust_month'];
            $accuICust[industrialAbb[4]][$row['no_month']] = (float)$row['as_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[4]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[4]][$row['no_month']] = (float)$row['as_cust_month'];
            $accuICust[industrialAbb[5]][$row['no_month']] = (float)$row['indust_cust_month'] + ($row['no_month'] == "1" ? 0 : (float)$accuICust[industrialAbb[5]][(int)$row['no_month']-1]);
            $eachICust[industrialAbb[5]][$row['no_month']] = (float)$row['indust_cust_month'];
        }
    }
    // /.Industrial Customer

    // Industrail indices
    {
        $sql = 'SELECT 
                    nikom, 
                    month(date) AS no_month,
                    sum(cust_num) AS cust_num_month, 
                    sum(cust_min) AS cust_min_month 
                FROM 
                    int_nikom  
                WHERE 
                    timeocb > 1 
                    AND event in("I", "O") 
                    AND major IS NULL 
                    AND year(date) = '.$selectedYear.' 
                GROUP BY
                    nikom, 
                    month(date)';
        
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo 'Something wrong!!! '.$e->getMessage();
        }
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        [$accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin] = fetchCustNumMin($row, (int)$lastedMonth);
        [$saifi, $saidi] = calculateAccuIndices($accuCustNum, $accuCustMin, $accuICust);
        [$saifiMonth, $saidiMonth] = calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachICust);
        if (industrialTarget[$selectedYear]) {
            [$saifiKpi, $saidiKpi] = calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget);
        } /*else {
            [$saifiMKpi, $saidiMKpi] = calculateComparePreviousYear($saifiM, $saidiM, $saifiMPrevious, $saidiMPrevious);
        }*/

        // Use unset() function delete elements 
        // if (!empty(industrialNotInYear[$selectedYear])) {// It has industrial not in selectedYear
        //     array_map('deleteIndustrialArray', industrialNotInYear[$selectedYear]);
        // }
        // function deleteIndustrialArray($value) {
        //     global $saifi, $saidi, $saifiMonth, $saidiMonth;
        //     unset($saifi[$value]);
        //     unset($saidi[$value]);
        //     unset($saifiMonth[$value]);
        //     unset($saidiMonth[$value]);
        // }

        // Create Array Response
        $res['saifi'] = $saifi;
        $res['saidi'] = $saidi;
        $res['saifiMonth'] = $saifiMonth;
        $res['saidiMonth'] = $saidiMonth;
        $res['saifiKpi'] = $saifiKpi;
        $res['saidiKpi'] = $saidiKpi;
    }
    // /.Industrail indices

    // Create Array Response
    {
        $res['lasted_year'] = $selectedYear;
        $res['lasted_month'] = $lastedMonth;
        $res['industrialTarget'] = industrialTarget[$selectedYear];
        $res['industrialNotInYear'] = empty(industrialNotInYear[$selectedYear]) ? null : industrialNotInYear[$selectedYear];
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
    function calculateAccuIndices($accuCustNum, $accuCustMin, $accuICust) {
        // print_r($accuICust);
        for ($n=0; $n < count($accuICust); $n++) {
            for ($i=1; $i <= count($accuICust[industrialAbb[$n]]); $i++) { 
                if ($accuICust[industrialAbb[$n]][$i] != 0) {
                    $saifi[industrialAbb[$n]][$i] = round($accuCustNum[industrialAbb[$n]][$i]/$accuICust[industrialAbb[$n]][$i]*$i, 3);
                    $saidi[industrialAbb[$n]][$i] = round($accuCustMin[industrialAbb[$n]][$i]/$accuICust[industrialAbb[$n]][$i]*$i, 3);
                } else {
                    $saifi[industrialAbb[$n]][$i] = 0.00;
                    $saidi[industrialAbb[$n]][$i] = 0.00;
                }
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Accumulative Indices

    // Calculate Each Month Indices
    function calculateEachMonthIndices($eachCustNum, $eachCustMin, $eachICust) {
        for ($n=0; $n < count($eachICust); $n++) {
            for ($i=1; $i <= count($eachICust[industrialAbb[$n]]); $i++) { 
                if ($eachICust[industrialAbb[$n]][$i] != 0) {
                    $saifi[industrialAbb[$n]][$i] = round($eachCustNum[industrialAbb[$n]][$i]/$eachICust[industrialAbb[$n]][$i], 3);
                    $saidi[industrialAbb[$n]][$i] = round($eachCustMin[industrialAbb[$n]][$i]/$eachICust[industrialAbb[$n]][$i], 3);
                } else {
                    $saifi[industrialAbb[$n]][$i] = 0.00;
                    $saidi[industrialAbb[$n]][$i] = 0.00;
                }
            }
        }
        return [$saifi, $saidi];
    }
    // /.Calculate Each Month Indices

    // Calculate KPI
    function calculateKPI($saifi, $saidi, $saifiTarget, $saidiTarget) {
        // for ($n=0; $n <= count($saifi) ; $n++) { 
            $n = 5; // for only calculate all industrial 
            for ($i=1; $i <= count($saifi[industrialAbb[$n]]); $i++) { 
                if ($saifiTarget[industrialAbb[$n]][$i] != 0) {
                    $saifiKpi[industrialAbb[$n]][$i] = round( ($saifi[industrialAbb[$n]][$i] - $saifiTarget[industrialAbb[$n]][$i]) / $saifiTarget[industrialAbb[$n]][$i] * 100, 2);
                } else {
                    $saifiKpi[industrialAbb[$n]][$i] = $saifi[industrialAbb[$n]][$i] > 0 ? 100 : -100;
                }

                if ($saidiTarget[industrialAbb[$n]][$i] != 0) {
                    $saidiKpi[industrialAbb[$n]][$i] = round( ($saidi[industrialAbb[$n]][$i] - $saidiTarget[industrialAbb[$n]][$i]) / $saidiTarget[industrialAbb[$n]][$i] * 100, 2);
                } else {
                    $saidiKpi[industrialAbb[$n]][$i] = $saidi[industrialAbb[$n]][$i] > 0 ? 100 : -100;
                }
            }
        // }

        return [$saifiKpi, $saidiKpi];
    }
    // /.Calculate KPI

    /*
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
    */

    // fectch PDO object to variable
    function fetchCustNumMin($row, $no_month=12) {        
        $accuCustNum = array();
        $eachCustNum = array();
        $accuCustMin = array();
        $eachCustMin = array();
        // initial value for all industrial "I"
        for ($i=0; $i <= $no_month ; $i++) { 
            $accuCustNum[industrialAbb[5]][$i] = 0.00;
            $eachCustNum[industrialAbb[5]][$i] = 0.00;
            $accuCustMin[industrialAbb[5]][$i] = 0.00;
            $eachCustMin[industrialAbb[5]][$i] = 0.00;
        }

        $x = 0; // count for index $row
        for ($n = 0; $n < count(industrialAbb)-1; $n++) {
            for ($i = 1; $i <= $no_month; $i++) {
                if (isset($row[$x]) && $row[$x]['nikom'] == industrialAbb[$n] && $row[$x]['no_month'] == $i) {
                    $accuCustNum[industrialAbb[$n]][$i] = (float)$row[$x]['cust_num_month'] + ($i-1 == 0 ? 0 : $accuCustNum[industrialAbb[$n]][$i-1]);
                    $eachCustNum[industrialAbb[$n]][$i] = (float)$row[$x]['cust_num_month'];
                    $accuCustMin[industrialAbb[$n]][$i] = (float)$row[$x]['cust_min_month'] + ($i-1 == 0 ? 0 : $accuCustMin[industrialAbb[$n]][$i-1]);
                    $eachCustMin[industrialAbb[$n]][$i] = (float)$row[$x]['cust_min_month'];
                    $x++;
                } else {
                    $accuCustNum[industrialAbb[$n]][$i] = ($i-1 == 0 ? 0 : $accuCustNum[industrialAbb[$n]][$i-1]);
                    $eachCustNum[industrialAbb[$n]][$i] = 0.00;
                    $accuCustMin[industrialAbb[$n]][$i] = ($i-1 == 0 ? 0 : $accuCustMin[industrialAbb[$n]][$i-1]);
                    $eachCustMin[industrialAbb[$n]][$i] = 0.00;
                }
                $accuCustNum[industrialAbb[5]][$i] += $accuCustNum[industrialAbb[$n]][$i];
                $eachCustNum[industrialAbb[5]][$i] += $eachCustNum[industrialAbb[$n]][$i];
                $accuCustMin[industrialAbb[5]][$i] += $accuCustMin[industrialAbb[$n]][$i];
                $eachCustMin[industrialAbb[5]][$i] += $eachCustMin[industrialAbb[$n]][$i];
            }
        }
        
        return array($accuCustNum, $eachCustNum, $accuCustMin, $eachCustMin);
    }
    // /fectch PDO object to variable
?>