$(function () {

    displayHilightMenu('sepa-focus-group-index');

    //Initialize Select2 Elements
    $('.select2').select2();
    
    //Event toggle between chart and table
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
        $('table').addClass('d-none');
        Array.from($('.chart').parent()).map(cardBodyElem => cardBodyElem.classList.remove('table-responsive','p-0'));
        // $('.chart').parent().removeClass('table-responsive','p-0');
        $('.chart').removeClass('d-none');
    });
    $(document).on('click', '[data-card-widget="tableAll"]', function (event) {
        event.preventDefault();
        $('.chart').addClass('d-none');
        Array.from($('.chart').parent()).map(cardBodyElem => cardBodyElem.classList.add('table-responsive','p-0'));
        $('table').removeClass('d-none');
    });

    //Declare Global Variable
    let dataStore = {}; // data as variable for store respond in each year
    let chartStore = {}; // chart as variable for store all chart
    const chartCanvas = [
        $('#chartCanvas1').get(0).getContext('2d'),
        $('#chartCanvas2').get(0).getContext('2d'),
        $('#chartCanvas3').get(0).getContext('2d'),
        $('#chartCanvas4').get(0).getContext('2d'),
        $('#chartCanvas5').get(0).getContext('2d'),
        $('#chartCanvas6').get(0).getContext('2d'),
    ];
    const chartIndexName = [
        'saifiM',
        'saidiM',
        'saifiLS',
        'saidiLS',
        'saifiF',
        'saidiF',
    ];
    const chartIndexMonthName = [
        'saifiMonthM',
        'saidiMonthM',
        'saifiMonthLS',
        'saidiMonthLS',
        'saifiMonthF',
        'saidiMonthF',
    ];
    const chartIndexPreviousName = [
        'saifiMPrevious',
        'saidiMPrevious',
        'saifiLSPrevious',
        'saidiLSPrevious',
        'saifiFPrevious',
        'saidiFPrevious',
    ];
    const chartIndexMonthPreviousName = [
        'saifiMonthMPrevious',
        'saidiMonthMPrevious',
        'saifiMonthLSPrevious',
        'saidiMonthLSPrevious',
        'saifiMonthFPrevious',
        'saidiMonthFPrevious',
    ];
    const chartTargetName = [
        'saifiMTarget',
        'saidiMTarget',
        'saifiLSTarget',
        'saidiLSTarget',
        'saifiFTarget',
        'saidiFTarget',
    ];
    const chartKpiName = [
        'saifiMKpi',
        'saidiMKpi',
        'saifiLSKpi',
        'saidiLSKpi',
        'saifiFKpi',
        'saidiFKpi',
    ];
    const chartBarColor = [
        'rgba(245, 105, 84, 0.9)',
        'rgba(245, 105, 84, 0.9)',
        'rgba(93, 173, 226, 0.9)',
        'rgba(93, 173, 226, 0.9)',
        'rgba(82, 190, 128, 0.9)',
        'rgba(82, 190, 128, 0.9)',
    ];
    const tableElements = [
        $('#tableCanvas1').find('tbody'),
        $('#tableCanvas2').find('tbody'),
        $('#tableCanvas3').find('tbody'),
        $('#tableCanvas4').find('tbody'),
        $('#tableCanvas5').find('tbody'),
        $('#tableCanvas6').find('tbody'),
    ];

    let cardElements;
    if (document.querySelectorAll('.card').length == 9) {
        cardElements = [
            document.querySelectorAll('.card')[1],
            document.querySelectorAll('.card')[2],
            document.querySelectorAll('.card')[3],
            document.querySelectorAll('.card')[4],
            document.querySelectorAll('.card')[5],
            document.querySelectorAll('.card')[6],
            document.querySelectorAll('.card')[7],
            document.querySelectorAll('.card')[8],
        ];
    } else {
        cardElements = [
            document.querySelectorAll('.card')[2],
            document.querySelectorAll('.card')[3],
            document.querySelectorAll('.card')[4],
            document.querySelectorAll('.card')[5],
            document.querySelectorAll('.card')[6],
            document.querySelectorAll('.card')[7],
            document.querySelectorAll('.card')[8],
            document.querySelectorAll('.card')[9],
        ];
    }

    //Get Data from sepa-focus-group-index-api.php
    getData(parseInt($('.select2').val())); //Run at first time only
    $('.select2').change(() => {
        // Add All Overlay Loading
        $('.overlay').removeClass('d-none');

        if (dataStore[parseInt($('.select2').val())]) {
            chartCanvas.map((chartCanvasElem, index) => {
                // Prepare data to plot
                let {chartData, chartOptions} = prepareDataPlot({selectedYear: parseInt($('.select2').val()), index});
                // Charts plots
                chartPlot({chartData, chartOptions, chartCanvasElem, index});
                // Dislay Kpi Card
                displayKpiCard({selectedYear: parseInt($('.select2').val()), index});
                // Table is filled data
                fillDataTable({selectedYear: parseInt($('.select2').val()), index});
            });
            // Remove All Overlay Loading
            $('.overlay').addClass('d-none');
        } else {
            // get new data
            getData(parseInt($('.select2').val()));
        }
    });

    // Utility function
    function getData(selectedYear) {
        $.get('./api/sepa-focus-group-index-api.php', {selectedYear : selectedYear-543}, function(res) {
            dataStore[parseInt(res.lasted_year)+543] = res;// global variable
            chartCanvas.map((chartCanvasElem, index) => {
                // Prepare data to plot
                let {chartData, chartOptions} = prepareDataPlot({selectedYear, index});
                // Charts plots
                chartPlot({chartData, chartOptions, chartCanvasElem, index});
                // Dislay Kpi Card
                displayKpiCard({selectedYear, index});
                // Table is filled data
                fillDataTable({selectedYear, index});
            });
            // Remove All Overlay Loading
            $('.overlay').addClass('d-none');
        });
    }

    function prepareDataPlot({selectedYear, index}) {// get data from global variable
        const yearData = dataStore[selectedYear];
        let accuIndex = Object.values(yearData[chartIndexName[index]]);
        let monthIndex = Object.values(yearData[chartIndexMonthName[index]]);
        let Target, subDatasets;
        if (yearData.sepaFocusHasTarget) {
            Target5 = Object.values(yearData[chartTargetName[index]][5]);
            Target1 = Object.values(yearData[chartTargetName[index]][1]);
            subDatasets = [
                {
                    type                : 'line',
                    // order               : 1,
                    fill                : '+1',
                    label               : chartIndexName[index].slice(0, 5).toUpperCase()+' 5',
                    backgroundColor     : 'rgba(245, 105, 84, 0.3)',
                    borderColor         : 'rgba(245, 105, 84, 1)',
                    borderWidth         : 1,
                    pointRadius         : 2,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : Target5
                },
                {
                    type                : 'line',
                    // order               : 1,
                    fill                : false,
                    label               : chartIndexName[index].slice(0, 5).toUpperCase()+' 1',
                    backgroundColor     : 'rgba(245, 105, 84, 0.3)',
                    borderColor         : 'rgba(245, 105, 84, 1)',
                    borderWidth         : 1,
                    pointRadius         : 2,
                    pointColor          : 'rgba(210, 214, 222, 1)',
                    pointStrokeColor    : '#c1c7d1',
                    pointHighlightFill  : '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data                : Target1
                }
            ];   
        } else { //sepaFocusHasTarget = false , as is no target in that year
            Target = Object.values(yearData[chartIndexPreviousName[index]]);
            subDatasets = [
                {
                    type                : 'line',
                    // order               : 1,
                    fill                : false,
                    label               : chartIndexName[index].slice(0, 5).toUpperCase() + ' ' + (selectedYear-1).toString(),
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
                    label               : chartIndexName[index].slice(0, 5).toUpperCase(),
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
                    label               : chartIndexName[index].slice(0, 5).toUpperCase() + ' Month',
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

    function chartPlot({chartData, chartOptions, chartCanvasElem, index}) {
        if ($.isEmptyObject(chartStore[index])) {
            const chart = new Chart(chartCanvasElem, {
                type: 'bar', 
                data: chartData,
                options: chartOptions
            })
            chartStore[index] = chart;
        } else { // Chart exist
            const chart = chartStore[index];
            // chart.data.datasets[0].data = chartData.datasets[0].data;
            chart.data.datasets = chartData.datasets;
            chart.update();
        }
    }

    function displayKpiCard({selectedYear, index}) {
        const yearData = dataStore[selectedYear];
        cardElements[index].classList.remove(cardElements[index].classList[1]);
        if (yearData.sepaFocusHasTarget) {
            yearData[chartKpiName[index]][yearData.lasted_month] == 5 ? 
                cardElements[index].classList.add('card-success') : 
                cardElements[index].classList.add('card-danger');
            cardElements[index].children[0].children[0].children[0].innerText = ' คิดเป็นคะแนน ' + yearData[chartKpiName[index]][yearData.lasted_month].toFixed(2);
        } else { //sepaFocusHasTarget = false , as is no target in that year
            yearData[chartKpiName[index]][yearData.lasted_month] <= 0 ? 
                cardElements[index].classList.add('card-success') : 
                cardElements[index].classList.add('card-danger');
            cardElements[index].children[0].children[0].children[0].innerText = ' คิดเป็น ' + yearData[chartKpiName[index]][yearData.lasted_month].toFixed(2) + '% เทียบกับปี ' + (selectedYear-1).toString();
        }
    }

    function fillDataTable({selectedYear, index}) {
        const yearData = dataStore[selectedYear];
        let tableData;
        if (yearData.sepaFocusHasTarget) {
            for (let i = 1; i <= 7; i++) {
                tableData += '<tr>';
                if (i < 6) {
                    tableData += '<th>KPI' + i + '</th>';
                    Object.values(yearData[chartTargetName[index]][i]).map(value => {
                        tableData += '<td>' + value.toFixed(3) + '</td>';
                    })
                } else if (i == 6) {
                    tableData += '<th>' + chartIndexName[index].slice(0, 5).toUpperCase() + '</th>';
                    Object.values(yearData[chartIndexName[index]]).map(value => {
                        tableData += '<td>' + value.toFixed(3) + '</td>';
                    })
                } else {
                    tableData += '<th>KPI</th>';
                    Object.values(yearData[chartKpiName[index]]).map(value => {
                        tableData += '<td>' + value.toFixed(3) + '</td>';
                    })
                }
                tableData += '</tr>'
            }    
            tableData += '<tr>';
        } else { //sepaFocusHasTarget = false , as is no target in that year
            for (let i = 1; i <= 3; i++) {
                tableData += '<tr>';
                if (i < 2) {
                    tableData += '<th>' + chartIndexName[index].slice(0, 5).toUpperCase() + ' ' + (selectedYear-1).toString() + '</th>';
                    Object.values(yearData[chartIndexPreviousName[index]]).map(value => {
                        tableData += '<td>' + value.toFixed(3) + '</td>';
                    })
                } else if (i == 2) {
                    tableData += '<th>' + chartIndexName[index].slice(0, 5).toUpperCase() + '</th>';
                    Object.values(yearData[chartIndexName[index]]).map(value => {
                        tableData += '<td>' + value.toFixed(3) + '</td>';
                    })
                } else {
                    tableData += '<th>% (- คือดีกว่า)</th>';
                    Object.values(yearData[chartKpiName[index]]).map(value => {
                        tableData += '<td>' + value.toFixed(2) + '</td>';
                    })
                }
                tableData += '</tr>'
            }    
            tableData += '<tr>';
        }

        tableElements[index].html(tableData)
    }
    // /.Utility function
});