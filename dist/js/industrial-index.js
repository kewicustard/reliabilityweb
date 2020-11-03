$(function () {

    displayHilightMenu('industrial-index');

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
        $('#chartCanvas7').get(0).getContext('2d'),
        $('#chartCanvas8').get(0).getContext('2d'),
        $('#chartCanvas9').get(0).getContext('2d'),
        $('#chartCanvas10').get(0).getContext('2d'),
        $('#chartCanvas11').get(0).getContext('2d'),
        $('#chartCanvas12').get(0).getContext('2d'),
    ];
    const chartIndexName = [
        'saifi',
        'saidi',
    ];
    const chartIndexMonthName = [
        'saifiMonth',
        'saidiMonth',
    ];
    const industrialAbb = [
        'I',
        'H',
        'L',
        'P',
        'U',
        'A',
    ];
    const chartTargetName = [
        'saifiTarget',
        'saidiTarget',
    ];
    const chartKpiName = [
        'saifiKpi',
        'saidiKpi',
    ];
    const chartBarColor = [
        'rgba(245, 105, 84, 0.9)',
        'rgba(245, 105, 84, 0.9)',
        'rgba(93, 173, 226, 0.9)',
        'rgba(93, 173, 226, 0.9)',
        'rgba(82, 190, 128, 0.9)',
        'rgba(82, 190, 128, 0.9)',
        'rgba(241, 196, 15, 0.9)',
        'rgba(241, 196, 15, 0.9)',
        'rgba(243, 156, 18, 0.9)',
        'rgba(243, 156, 18, 0.9)',
        'rgba(0, 192, 239, 0.9)',
        'rgba(0, 192, 239, 0.9)',
    ];
    const tableElements = [
        $('#tableCanvas1').find('tbody'),
        $('#tableCanvas2').find('tbody'),
        $('#tableCanvas3').find('tbody'),
        $('#tableCanvas4').find('tbody'),
        $('#tableCanvas5').find('tbody'),
        $('#tableCanvas6').find('tbody'),
        $('#tableCanvas7').find('tbody'),
        $('#tableCanvas8').find('tbody'),
        $('#tableCanvas9').find('tbody'),
        $('#tableCanvas10').find('tbody'),
        $('#tableCanvas11').find('tbody'),
        $('#tableCanvas12').find('tbody'),
    ];

    

    let cardElements;
    if (document.querySelectorAll('.card').length == 13) {
        cardElements = [
            document.querySelectorAll('.card')[1],
            document.querySelectorAll('.card')[2],
            document.querySelectorAll('.card')[3],
            document.querySelectorAll('.card')[4],
            document.querySelectorAll('.card')[5],
            document.querySelectorAll('.card')[6],
            document.querySelectorAll('.card')[7],
            document.querySelectorAll('.card')[8],
            document.querySelectorAll('.card')[9],
            document.querySelectorAll('.card')[10],
            document.querySelectorAll('.card')[11],
            document.querySelectorAll('.card')[12],
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
            document.querySelectorAll('.card')[10],
            document.querySelectorAll('.card')[11],
            document.querySelectorAll('.card')[12],
            document.querySelectorAll('.card')[13],
        ];
    }

    //Get Data from strategy-index.php
    getData(parseInt($('.select2').val())); //Run at first time only
    $('.select2').change(() => {
        // Add All Overlay Loading
        $('.overlay').removeClass('d-none');

        if (dataStore[parseInt($('.select2').val())]) {
            // Hide and show industrial not in selectedYear
            hideShowIndustrailElem({selectedYear: parseInt($('.select2').val())});
            // Update chart and table
            chartCanvas.map((chartCanvasElem, index) => {
                // Prepare data to plot
                let {chartData, chartOptions} = prepareDataPlot({selectedYear: parseInt($('.select2').val()), industrialAbb : industrialAbb[parseInt(index/2)], index});
                // Charts plots
                chartPlot({chartData, chartOptions, chartCanvasElem, index});
                // Dislay Kpi Card
                (industrialAbb[parseInt(index/2)] == 'I') ? displayKpiCard({selectedYear: parseInt($('.select2').val()), index}) : null;
                // Table is filled data
                fillDataTable({selectedYear: parseInt($('.select2').val()), industrialAbb : industrialAbb[parseInt(index/2)], index});
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
        $.get('./api/industrial-index-api.php', {selectedYear : selectedYear-543}, function(res) {
            dataStore[parseInt(res.lasted_year)+543] = res;// global variable
            // Hide and show industrial not in selectedYear
            hideShowIndustrailElem({selectedYear});
            // Create chart and table
            chartCanvas.map((chartCanvasElem, index) => {
                // Prepare data to plot
                let {chartData, chartOptions} = prepareDataPlot({selectedYear, industrialAbb : industrialAbb[parseInt(index/2)], index});
                // Charts plots
                chartPlot({chartData, chartOptions, chartCanvasElem, index});
                // Dislay Kpi Card
                (industrialAbb[parseInt(index/2)] == 'I') ? displayKpiCard({selectedYear, index}) : null;
                // Table is filled data
                fillDataTable({selectedYear, industrialAbb : industrialAbb[parseInt(index/2)], index});
            });
            // Remove All Overlay Loading
            $('.overlay').addClass('d-none');
        });
    }

    function prepareDataPlot({selectedYear, industrialAbb, index}) {// get data from global variable
        const yearData = dataStore[selectedYear];
        let indexMod = parseInt(index % 2);
        let accuIndex = Object.values(yearData[chartIndexName[indexMod]][industrialAbb]);
        let monthIndex = Object.values(yearData[chartIndexMonthName[indexMod]][industrialAbb]);
        let subDatasets;
        if (yearData.industrialTarget) {
            if (industrialAbb != 'I') { // for any Target
                subDatasets = [];
            } else { // for all industrial Target
                let Target = Object.values(yearData[chartTargetName[indexMod]][industrialAbb]);
                subDatasets = [
                    {
                        type                : 'line',
                        // order               : 1,
                        fill                : '+1',
                        label               : 'เกณฑ์ ' + chartIndexName[indexMod].slice(0, 5).toUpperCase(),
                        backgroundColor     : 'rgba(245, 105, 84, 0.3)',
                        borderColor         : 'rgba(245, 105, 84, 1)',
                        borderWidth         : 1,
                        pointRadius         : 2,
                        pointColor          : 'rgba(210, 214, 222, 1)',
                        pointStrokeColor    : '#c1c7d1',
                        pointHighlightFill  : '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data                : Target
                    },
                ]
            }   
        }
        
        let chartData = {
            labels  : ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            datasets: subDatasets.concat([ 
                {
                    type                : 'bar',
                    // order               : 2,
                    label               : chartIndexName[indexMod].slice(0, 5).toUpperCase(),
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
                    label               : chartIndexName[indexMod].slice(0, 5).toUpperCase() + ' Month',
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
        if (yearData.industrialTarget) {
            if (yearData[chartKpiName[index]]['I'][yearData.lasted_month] < 0) {
                cardElements[index].classList.add('card-success');
                cardElements[index].children[0].children[0].children[0].innerText = ' ดีกว่าเกณฑ์';
            } else {
                cardElements[index].classList.add('card-danger');
                cardElements[index].children[0].children[0].children[0].innerText = ' สูงเกินเกณฑ์';
            }
        }
    }

    function fillDataTable({selectedYear, industrialAbb, index}) {
        const yearData = dataStore[selectedYear];
        let indexMod = parseInt(index % 2);
        let tableData;
        if (yearData.industrialTarget) {
            if (index > 1) {
                tableData += '<tr>';
                tableData += '<th>' + chartIndexName[indexMod].slice(0, 5).toUpperCase() + '</th>';
                Object.values(yearData[chartIndexName[indexMod]][industrialAbb]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr>';

            } else { // for all industrial
                tableData += '<tr>';
                tableData += '<th>เกณฑ์</th>';
                Object.values(yearData[chartTargetName[indexMod]][industrialAbb]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr>';
                tableData += '<tr>';
                tableData += '<th>' + chartIndexName[indexMod].slice(0, 5).toUpperCase() + '</th>';
                Object.values(yearData[chartIndexName[indexMod]][industrialAbb]).map(value => {
                    tableData += '<td>' + value.toFixed(3) + '</td>';
                })
                tableData += '</tr>';
            }
        }

        tableElements[index].html(tableData)
    }

    function hideShowIndustrailElem({selectedYear}) {
        const yearData = dataStore[selectedYear];
        let rowElem = Array.from(document.querySelectorAll('section.row'))[5];
        // Hide or show Asia suvannabhumi
        if (yearData['industrialNotInYear'] == null) {
            rowElem.classList.remove('d-none');
            rowElem.previousElementSibling.classList.remove('d-none');
        } else {
            rowElem.classList.add('d-none');
            rowElem.previousElementSibling.classList.add('d-none');
        }
    }
    // /.Utility function
});