$(function () {

    displayHilightMenu('district-sepa-index');

    //Initialize Select2 Elements
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    //Event toggle between chart and table
    const tabChart1Elem = document.querySelector('[href="#tab_1"]');
    tabChart1Elem.addEventListener("click", () => {
      const cardBodySaifiElem = document.querySelector('#tab_1').parentElement.parentElement;
      cardBodySaifiElem.classList.remove('table-responsive');
      cardBodySaifiElem.classList.remove('p-0');
    });
    const tabTable1Elem = document.querySelector('[href="#tab_2"]');
    tabTable1Elem.addEventListener("click", () => {
      const cardBodySaifiElem = document.querySelector('#tab_2').parentElement.parentElement;
      cardBodySaifiElem.classList.add('table-responsive');
      cardBodySaifiElem.classList.add('p-0');
    });
    const tabChart2Elem = document.querySelector('[href="#tab_3"]');
    tabChart2Elem.addEventListener("click", () => {
      const cardBodySaidiElem = document.querySelector('#tab_3').parentElement.parentElement;
      cardBodySaidiElem.classList.remove('table-responsive');
      cardBodySaidiElem.classList.remove('p-0');
    });
    const tabTable2Elem = document.querySelector('[href="#tab_4"]');
    tabTable2Elem.addEventListener("click", () => {
      const cardBodySaidiElem = document.querySelector('#tab_4').parentElement.parentElement;
      cardBodySaidiElem.classList.add('table-responsive');
      cardBodySaidiElem.classList.add('p-0');
    });

    $(document).on('click', '[data-card-widget="chart"]', function (event) {
        event.preventDefault();
        let button = event.currentTarget;
        let card = button.closest('.card');
        card.children[1].children[1].classList.add('d-none');
        card.children[1].classList.remove('table-responsive','p-0');
        card.children[1].children[0].classList.remove('d-none');
    });
    $(document).on('click', '[data-card-widget="table"]', function (event) {
        event.preventDefault();
        let button = event.currentTarget;
        let card = button.closest('.card');
        card.children[1].children[0].classList.add('d-none');
        card.children[1].classList.add('table-responsive','p-0');
        card.children[1].children[1].classList.remove('d-none');
    });
    $(document).on('click', '[data-card-widget="chartAll"]', function (event) {
        event.preventDefault();
        if (showAllDist === true) {
            document.querySelector('[href="#tab_1"').click();
            document.querySelector('[href="#tab_3"').click();
        } else {
            Array.from(tableEachDistElements).map((tableElem, index) => {
                tableElem.prevObject[0].parentElement.classList.remove('table-responsive','p-0');
                tableElem.prevObject[0].classList.add('d-none');
                tableElem.prevObject[0].previousElementSibling.classList.remove('d-none');
            });
        }
    });
    $(document).on('click', '[data-card-widget="tableAll"]', function (event) {
        event.preventDefault();
        if (showAllDist === true) {
            document.querySelector('[href="#tab_2"').click();
            document.querySelector('[href="#tab_4"').click();
        } else {
            Array.from(tableEachDistElements).map((tableElem, index) => {
                tableElem.prevObject[0].previousElementSibling.classList.add('d-none');
                tableElem.prevObject[0].parentElement.classList.add('table-responsive','p-0');
                tableElem.prevObject[0].classList.remove('d-none');
            });
        }
    });

    //Declare Golbal Variable
    let dataStore = {};
    let chartAllDistStore = {};
    let chartEachDistStore = {};
    let selectedYearElem = $('select')[0];
    let selectedDistrictElem = $('select')[1];
    let rowAllDistrict = $('.row')[3];
    let rowEachDistrict = $('.row')[4];
    let monthName = {
        1 : 'มกราคม',
        2 : 'กุมภาพันธ์',
        3 : 'มีนาคม',
        4 : 'เมษายน',
        5 : 'พฤษภาคม',
        6 : 'มิถุนายน',
        7 : 'กรกฎาคม',
        8 : 'สิงหาคม',
        9 : 'กันยายน',
        10 : 'ตุลาคม',
        11 : 'พฤศจิกายน',
        12 : 'ธันวาคม',
    };
    let showAllDist;

    const chartAllDistElements = [
        document.querySelectorAll('.chart')[0],
        document.querySelectorAll('.chart')[1],
    ];
    const chartEachDistElements = [
        document.querySelectorAll('.chart')[2],
        document.querySelectorAll('.chart')[3],
    ];
    const chartCanvasAll = [
        $('#chartCanvas1').get(0).getContext('2d'),
        $('#chartCanvas2').get(0).getContext('2d'),
    ];
    const chartCanvaseEachDist = [
        $('#chartCanvas3').get(0).getContext('2d'),
        $('#chartCanvas4').get(0).getContext('2d'),
    ];
    const chartIndexName = [
        'saifi',
        'saidi',
    ];
    const chartIndexMonthName = [
        'saifiMonth',
        'saidiMonth',
    ];
    const chartIndexPreviousName = [
        'saifiPrevious',
        'saidiPrevious',
    ];
    const chartIndexMonthPreviousName = [
        'saifiMonthPrevious',
        'saidiMonthPrevious',
    ];
    const chartTargetName = [
        'saifiTarget',
        'saidiTarget',
    ]
    const chartKpiName = [
        'saifiKpi',
        'saidiKpi',
    ];
    const chartBarColor = [
        'rgba(93, 173, 226, 0.9)',
        'rgba(82, 190, 128, 0.9)',
    ];
    const tableAllDistElements = [
        $('#tableCanvas1').find('tbody'),
        $('#tableCanvas2').find('tbody'),
    ];
    const tableEachDistElements = [
        $('#tableCanvas3').find('tbody'),
        $('#tableCanvas4').find('tbody'),
    ];
    
    let cardAllDistElements;
    let cardEachDistElements;
    if (document.querySelectorAll('.card').length == 5) {
        cardAllDistElements = [
            document.querySelectorAll('.card')[1],
            document.querySelectorAll('.card')[2],
        ];
        cardEachDistElements = [
            document.querySelectorAll('.card')[3],
            document.querySelectorAll('.card')[4],
        ];
    } else {
        cardAllDistElements = [
            document.querySelectorAll('.card')[2],
            document.querySelectorAll('.card')[3],
        ];
        cardEachDistElements = [
            document.querySelectorAll('.card')[4],
            document.querySelectorAll('.card')[5],
        ];
    }
    
    //Get Data from district-sepa-index-api.php
    getData(parseInt(selectedYearElem.options[selectedYearElem.selectedIndex].text)); //Run at first time only
    $("[name='show']").click(function() {
        const selectedYear = parseInt(selectedYearElem.options[selectedYearElem.selectedIndex].text);
        const selectedDistrictValue = parseInt(selectedDistrictElem.options[selectedDistrictElem.selectedIndex].value);
          
        // Add All Overlay Loading
        $('.overlay').removeClass('d-none');
        
        if (dataStore[selectedYear]) {
            if (selectedDistrictValue === 0) {
                showAllDist = true;
                rowAllDistrict.classList.remove('d-none');
                rowEachDistrict.classList.add('d-none');
                chartCanvasAll.map((chartCanvasElem, index) => {
                    // Prepare data to plot
                    let {chartData, chartOptions} = prepareDataAllDistPlot({selectedYear, index});
                    // Charts plots
                    chartAllDistPlot({chartData, chartOptions, chartCanvasElem, index});
                    // Dislay All District Card
                    displayAllDistKpiCard({selectedYear, index});
                    // Table is filled data
                    fillAllDistDataTable({selectedYear, index});
                })
            } else { //parseInt(selectedDsitrictElem.value) !== 0
                showAllDist = false;
                rowAllDistrict.classList.add('d-none');
                rowEachDistrict.classList.remove('d-none');
                rowEachDistrict.children[0].children[0].innerText = 'การไฟฟ้านครหลวงเขต ' + selectedDistrictElem.options[selectedDistrictElem.selectedIndex].text;
                chartCanvaseEachDist.map((chartCanvasElem, index) => {
                    // Prepare data to plot
                    let {chartData, chartOptions} = prepareDataEachDistPlot({selectedYear, selectedDistrictValue, index});
                    // Charts plots
                    chartEachDistPlot({chartData, chartOptions, chartCanvasElem, index});
                    // Dislay Kpi Each District Card
                    displayEachDistKpiCard({selectedYear, selectedDistrictValue, index});
                    // Table is filled data
                    fillEachDistDataTable({selectedYear, selectedDistrictValue, index});
                })
            }
            // Remove All Overlay Loading
            $('.overlay').addClass('d-none');
        } else {
            getData(selectedYear);
        }        
    });

    // Utility function
    function getData(selectedYear) {
        const selectedDistrictValue = parseInt(selectedDistrictElem.options[selectedDistrictElem.selectedIndex].value);

        $.get('./api/district-sepa-index-api.php', {selectedYear : selectedYear-543}, function(res) {
            dataStore[parseInt(res.lasted_year)+543] = res;// global variable
            if (selectedDistrictValue === 0) {
                showAllDist = true;
                rowAllDistrict.classList.remove('d-none');
                rowEachDistrict.classList.add('d-none');
                chartCanvasAll.map((chartCanvasElem, index) => {
                    // Prepare data to plot
                    let {chartData, chartOptions} = prepareDataAllDistPlot({selectedYear, index});
                    // Charts plots
                    chartAllDistPlot({chartData, chartOptions, chartCanvasElem, index});
                    // Dislay All District Card
                    displayAllDistKpiCard({selectedYear, index});
                    // Table is filled data
                    fillAllDistDataTable({selectedYear, index});
                })
            } else { //parseInt(selectedDsitrictElem.value) !== 0
                showAllDist = false;
                rowAllDistrict.classList.add('d-none');
                rowEachDistrict.classList.remove('d-none');
                rowEachDistrict.children[0].children[0].innerText = 'การไฟฟ้านครหลวงเขต ' + selectedDistrictElem.options[selectedDistrictElem.selectedIndex].text;
                chartCanvaseEachDist.map((chartCanvasElem, index) => {
                    // Prepare data to plot
                    let {chartData, chartOptions} = prepareDataEachDistPlot({selectedYear, selectedDistrictValue, index});
                    // Charts plots
                    chartEachDistPlot({chartData, chartOptions, chartCanvasElem, index});
                    // Dislay Kpi Each District Card
                    displayEachDistKpiCard({selectedYear, selectedDistrictValue, index});
                    // Table is filled data
                    fillEachDistDataTable({selectedYear, selectedDistrictValue, index});
                })
            }
            // Remove All Overlay Loading
            $('.overlay').addClass('d-none');
        });
    }

    function prepareDataAllDistPlot({selectedYear, index}) {// get data from global variable
        const yearData = dataStore[selectedYear];
        let accuIndex = [];
        for (let x in yearData[chartIndexName[index]]) {
            accuIndex.push(yearData[chartIndexName[index]][x][yearData['lasted_month']]);
        }
        
        // let monthIndex = Object.values(yearData[chartIndexMonthName[index]]);
        let Target = [], subDatasets;
        if (yearData.sepaHasTarget) {
            for (let x in yearData[chartTargetName[index]]) {
                Target.push(yearData[chartTargetName[index]][x][5][yearData['lasted_month']]);
                subDatasets = [
                    {
                        type                : 'line',
                        // order               : 1,
                        fill                : false,
                        label               : chartIndexName[index].toUpperCase() + ' 5',
                        backgroundColor     : 'rgba(245, 105, 84, 0.2)',
                        borderColor         : 'rgba(245, 105, 84, 1)',
                        borderWidth         : 1,
                        pointRadius         : 2,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : Target
                    }
                ];
            }
        } else {
            for (let x in yearData[chartIndexPreviousName[index]]) {
                Target.push(yearData[chartIndexPreviousName[index]][x][yearData['lasted_month']]);
                subDatasets = [
                    {
                        type                : 'line',
                        // order               : 1,
                        fill                : false,
                        label               : chartIndexName[index].toUpperCase() + ' ' + (selectedYear-1).toString(),
                        backgroundColor     : 'rgba(245, 105, 84, 0.2)',
                        borderColor         : 'rgba(245, 105, 84, 1)',
                        borderWidth         : 1,
                        pointRadius         : 2,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : Target
                    }
                ];
            }
        }
        
        let chartData = {
            labels  : Object.values(yearData.tabb),//['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            datasets: subDatasets.concat([ 
                {
                    type                : 'bar',
                    // order               : 2,
                    label               : chartIndexName[index].toUpperCase(),
                    backgroundColor     : chartBarColor[index],
                    borderColor         : chartBarColor[index],
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : accuIndex,
                },
            ])
        };

        const chartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            tooltips: {
                mode: 'index',
                intersect: true,
                callbacks: {
                    label: function (tooltipItem, data) {
                        let label = data.datasets[tooltipItem.datasetIndex].label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += Number(tooltipItem.yLabel).toFixed(3);
                        return label;
                    }
                }
            }
        }

        return {chartData, chartOptions};
    }

    function chartAllDistPlot({chartData, chartOptions, chartCanvasElem, index}) {
        if ($.isEmptyObject(chartAllDistStore[index])) {
            const chart = new Chart(chartCanvasElem, {
                type: 'bar', 
                data: chartData,
                options: chartOptions
            })
            chartAllDistStore[index] = chart;
        } else { // Chart exist
            const chart = chartAllDistStore[index];
            // chart.data.datasets[0].data = chartData.datasets[0].data;
            chart.data.datasets = chartData.datasets;
            chart.update();
        }
    }

    function prepareDataEachDistPlot({selectedYear, selectedDistrictValue, index}) {// get data from global variable
        const yearData = dataStore[selectedYear];
        let accuIndex = Object.values(yearData[chartIndexName[index]][selectedDistrictValue]);
        let monthIndex = Object.values(yearData[chartIndexMonthName[index]][selectedDistrictValue]);
        let Target = [], subDatasets;
        if (yearData.sepaHasTarget) {
            Target = Object.values(yearData[chartTargetName[index]][selectedDistrictValue][5]);
            subDatasets = [
                {
                    type                : 'line',
                    // order               : 1,
                    fill                : false,
                    label               : chartIndexName[index].toUpperCase() + ' 5',
                    backgroundColor     : 'rgba(245, 105, 84, 0.2)',
                    borderColor         : 'rgba(245, 105, 84, 1)',
                    borderWidth         : 1,
                    pointRadius         : 2,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : Target
                }
            ];
        } else {
            Target = Object.values(yearData[chartIndexPreviousName[index]][selectedDistrictValue]);
            subDatasets = [
                {
                    type                : 'line',
                    // order               : 1,
                    fill                : false,
                    label               : chartIndexName[index].toUpperCase() + ' ' + (selectedYear-1).toString(),
                    backgroundColor     : 'rgba(245, 105, 84, 0.2)',
                    borderColor         : 'rgba(245, 105, 84, 1)',
                    borderWidth         : 1,
                    pointRadius         : 2,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : Target
                }
            ];
        }
        
        let chartData = {
            labels  : ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            datasets: subDatasets.concat([ 
                {
                    type                : 'bar',
                    // order               : 2,
                    label               : chartIndexName[index].toUpperCase(),
                    backgroundColor     : chartBarColor[index],
                    borderColor         : chartBarColor[index],
                    pointRadius         : false,
                    pointColor          : '#3b8bba',
                    pointStrokeColor    : 'rgba(60,141,188,1)',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data                : accuIndex,
                },
                {
                    type                : 'bar',
                    // order               : 3,
                    label               : chartIndexName[index].toUpperCase() + ' Month',
                    backgroundColor     : 'rgba(210, 214, 222, 1)',
                    borderColor         : 'rgba(210, 214, 222, 1)',
                    pointRadius         : false,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : monthIndex
                },
            ])
        };

        const chartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false,
            tooltips: {
                mode: 'index',
                intersect: true,
                callbacks: {
                    label: function (tooltipItem, data) {
                        let label = data.datasets[tooltipItem.datasetIndex].label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += Number(tooltipItem.yLabel).toFixed(3);
                        return label;
                    }
                }
            }
        }

        return {chartData, chartOptions};
    }

    function chartEachDistPlot({chartData, chartOptions, chartCanvasElem, index}) {
        if ($.isEmptyObject(chartEachDistStore[index])) {
            const chart = new Chart(chartCanvasElem, {
                type: 'bar', 
                data: chartData,
                options: chartOptions
            })
            chartEachDistStore[index] = chart;
        } else { // Chart exist
            const chart = chartEachDistStore[index];
            // chart.data.datasets[0].data = chartData.datasets[0].data;
            chart.data.datasets = chartData.datasets;
            chart.update();
        }
    }

    function displayAllDistKpiCard({selectedYear, index}) {
        const yearData = dataStore[selectedYear];
        cardAllDistElements[index].children[0].children[0].children[0].innerText = ' สะสมถึงเดือน ' + monthName[yearData.lasted_month] + ' ' +selectedYear.toString();
    }

    function displayEachDistKpiCard({selectedYear, selectedDistrictValue, index}) {
        const yearData = dataStore[selectedYear];
        cardEachDistElements[index].classList.remove(cardEachDistElements[index].classList[1]);
        if (yearData.sepaHasTarget) {
            yearData[chartKpiName[index]][selectedDistrictValue][yearData.lasted_month] <= 0 ? 
                cardEachDistElements[index].classList.add('card-success') : 
                cardEachDistElements[index].classList.add('card-danger');
            cardEachDistElements[index].children[0].children[0].children[0].innerText = ' คิดเป็น ' + yearData[chartKpiName[index]][selectedDistrictValue][yearData.lasted_month].toFixed(2) + '% เทียบกับเป้าหมายรสะสมรายเดือน';
        } else { //sepaHasTarget = false , as is no target in that year
            yearData[chartKpiName[index]][selectedDistrictValue][yearData.lasted_month] <= 0 ? 
                cardEachDistElements[index].classList.add('card-success') : 
                cardEachDistElements[index].classList.add('card-danger');
            cardEachDistElements[index].children[0].children[0].children[0].innerText = ' คิดเป็น ' + yearData[chartKpiName[index]][selectedDistrictValue][yearData.lasted_month].toFixed(2) + '% เทียบกับปี ' + (selectedYear-1).toString();
        }
    }

    function fillAllDistDataTable({selectedYear, index}) {
        const yearData = dataStore[selectedYear];
        let tableData;
        if (yearData.sepaHasTarget) {
            for (let i = 1; i <= Object.keys(yearData[chartTargetName[index]]).length; i++) {
                tableData += '<tr>';
                tableData += '<th>' + yearData.tabb[i] + '</th>';
                tableData += '<th>KPI5</th>';
                Object.values(yearData[chartTargetName[index]][i][5]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr><tr>';
                tableData += '<th>' + yearData.tabb[i] + '</th>';
                tableData += '<th>' + chartIndexName[index].toUpperCase() + '</th>';
                Object.values(yearData[chartIndexName[index]][i]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr>'
            }
        } else { //sepaHasTarget = false , as is no target in that year
            for (let i = 1; i <= Object.keys(yearData[chartIndexPreviousName[index]]).length; i++) {
                tableData += '<tr>';
                tableData += '<th>' + yearData.tabb[i] + '</th>';
                tableData += '<th>' + chartIndexName[index].toUpperCase() + ' ' + (selectedYear-1).toString() + '</th>';
                Object.values(yearData[chartIndexPreviousName[index]][i]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr><tr>';
                tableData += '<th>' + yearData.tabb[i] + '</th>';
                tableData += '<th>' + chartIndexName[index].toUpperCase() + '</th>';
                Object.values(yearData[chartIndexName[index]][i]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr>'
            }
        }

        tableAllDistElements[index].html(tableData);
    }

    function fillEachDistDataTable({selectedYear, selectedDistrictValue, index}) {
        const yearData = dataStore[selectedYear];
        let tableData;
        if (yearData.sepaHasTarget) {
            tableData += '<tr>';
            tableData += '<th>KPI5</th>';
            Object.values(yearData[chartTargetName[index]][selectedDistrictValue][5]).map(value => {
                tableData += '<td>' + value.toFixed(3) + '</td>';
            })
            tableData += '</tr><tr>';
            tableData += '<th>' + chartIndexName[index].toUpperCase() + '</th>';
            Object.values(yearData[chartIndexName[index]][selectedDistrictValue]).map(value => {
                tableData += '<td>' + value.toFixed(3) + '</td>';
            })
            tableData += '</tr>';
        } else { //sepaHasTarget = false , as is no target in that year
            tableData += '<tr>';
            tableData += '<th>' + chartIndexName[index].toUpperCase() + ' ' + (selectedYear-1).toString() + '</th>';
            Object.values(yearData[chartIndexPreviousName[index]][selectedDistrictValue]).map(value => {
                tableData += '<td>' + value.toFixed(3) + '</td>';
            })
            tableData += '</tr><tr>';
            tableData += '<th>' + chartIndexName[index].toUpperCase() + '</th>';
            Object.values(yearData[chartIndexName[index]][selectedDistrictValue]).map(value => {
                tableData += '<td>' + value.toFixed(3) + '</td>';
            })
            tableData += '</tr>';
        }
        tableEachDistElements[index].html(tableData);
    }
    // /.Utility function
});