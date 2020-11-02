$(function () {

    displayHilightMenu('search-line-index');

    // Define variable
    const activeFormElems = [
      $('#line'),
      $('#cause')
    ];
    // /.Define variable

    // Prevent page refresh when press 'enter' after key in textbox
    $('[name="lineName"]').bind('keydown', function(e) { //on keydown for all textboxes  
      if(e.keyCode==13) { //if this is enter key  
        e.preventDefault();
        $(this).blur();
      }
    });
    // /.Prevent page refresh when press 'enter' after key in textbox

    // Initialize Select2 Elements
    $.get('./api/fetch-cause-api.php', function(res) {
      let data = Object.values(res).sort(compare);
      data.splice(0, 0, {
        id: '000',
        text: 'เลือกทุกสาเหตุ'
      });
      $('[name="selectedCauses[]"]').select2({
        data,
        allowClear: true,
      });
      // $('[name="selectedCauses[]"]').val('000').trigger('change');

      $('[name="selectedCauses[]"]').on('select2:select', function (e) {
        let selectedId = e.params.data.id;
        if (selectedId==='000') {
          $.each(this.options, function (i, item) {
            if (!(item.value===selectedId)) {
              $(item).prop("disabled", true); 
            }
          });
        } else {
          $.each(this.options, function (i, item) {
            if ((item.value.substr(0, 2)===selectedId.substr(0,2)) && (selectedId.substr(2, 1)==='0')) {
                $(item).prop("disabled", true); 
            }
          });
        }     
        $('[name="selectedCauses[]"]').select2({
          allowClear: true
        });

      });

      $('[name="selectedCauses[]"]').on('select2:unselect', function (e) {
        let unselectedId = e.params.data.id;
        if (unselectedId==='000') {
          $.each(this.options, function (i, item) {
            if (!(item.value===unselectedId)) {
              $(item).prop("disabled", false); 
            }
          });
        } else {
          $.each(this.options, function (i, item) {
            if ((item.value.substr(0, 2)===unselectedId.substr(0,2)) && (unselectedId.substr(2, 1)==='0')) {
              $(item).prop("disabled", false); 
            }
          });
        }
      });
    });

    // Initialize Datetimepicker
    $.get('./api/search-line-outage-date-range-api.php', function(res) {
      moment.locale('th');
      $('.h6').append(`สามารถสืบค้นข้อมูลได้ตั้งแต่ ${moment([moment(res.oldest_date).year(), 0, 1]).format('ll')} ถึง ${moment([moment(res.lasted_date).year(), moment(res.lasted_date).month(), moment(res.lasted_date).endOf('month').format('D')]).format('ll')}`);
      $('#datetimepickerFrom').datetimepicker({
        format: 'll',
        minDate: moment([moment(res.oldest_date).year(), 0, 1]),
        maxDate: moment([moment(res.lasted_date).year(), moment(res.lasted_date).month(), moment(res.lasted_date).endOf('month').format('D')]),
        defaultDate: moment([moment(res.lasted_date).year(), moment(res.lasted_date).month(), 1]),
        locale: moment.locale('th'),
      });
      $('#datetimepickerTo').datetimepicker({
          format: 'll',
          useCurrent: false,
          minDate: moment([moment(res.oldest_date).year(), 0, 1]),
          maxDate: moment([moment(res.lasted_date).year(), moment(res.lasted_date).month(), moment(res.lasted_date).endOf('month').format('D')]),
          defaultDate: moment([moment(res.lasted_date).year(), moment(res.lasted_date).month(), moment(res.lasted_date).endOf('month').format('D')]),
          locale: moment.locale('th'),
      });
      $("#datetimepickerFrom").on("change.datetimepicker", function (e) {
        $('#datetimepickerTo').datetimepicker('minDate', e.date);
      });
      $("#datetimepickerTo").on("change.datetimepicker", function (e) {
        $('#datetimepickerFrom').datetimepicker('maxDate', e.date);
      });
    });    

    // Event click submit
    const interruptionType = [
      'all',
      'sustain',
      'momentary'
    ];
    const monthNumber = {
      "ม.ค." : 1,
      "ก.พ." : 2,
      "มี.ค." : 3,
      "เม.ย." : 4,
      "พ.ค." : 5,
      "มิ.ย." : 6,
      "ก.ค." : 7,
      "ส.ค." : 8,
      "ก.ย." : 9,
      "ต.ค." : 10,
      "พ.ย." : 11,
      "ธ.ค." : 12,
    };
    // let table;

    $('[type="submit"]').click((e) => {
      e.preventDefault();
      let selectedForm = activeFormElems.filter(activeFormElem => activeFormElem.attr('class').includes('active'))
      if (selectedForm[0].attr('id') === 'line') {
        if (validateLine({selectedInputElem : selectedForm[0].find('[name="lineName"]'), selectedCheckElem : selectedForm[0].find('#allLine')})) {
          //Collapse search input card
          $('[data-card-widget="collapse"').click();
          if (typeof table === 'undefined') {
            createDataTable();
          } else {
            //Add overlay card
            $('.overlay').removeClass('d-none');
            table.ajax.reload()
          }
          $('.container-fluid > .row:eq(2)').removeClass('d-none');
        }

      } else { // id='cause'
        if ($('[name="selectedCauses[]"]').select2('data').length) {
          //Collapse search input card
          $('[data-card-widget="collapse"').click();
          if (typeof table === 'undefined') {
            createDataTable();
          } else {
            //Add overlay card
            $('.overlay').removeClass('d-none');
            table.ajax.reload()
          }
          $('.container-fluid > .row:eq(2)').removeClass('d-none');
        } else {
          $('[name="selectedCauses[]"]').select2('open');
        }
      }

      function validateLine({selectedInputElem, selectedCheckElem}) {
        const validateValue = selectedInputElem.val().trim();
        const validateAllLine = selectedCheckElem.is(':checked');
        if (validateValue === "" && !validateAllLine) {
          selectedInputElem.addClass('is-invalid');
          selectedInputElem.focus();
          selectedInputElem.next().next().removeClass('d-none');
          return false;
        }
        if (validateValue !== "" && !validateAllLine) {
          if (!( (/^[a-zA-Z]{3}$/.test(validateValue)) || (/^[a-zA-Z]{3}-$/.test(validateValue)) || (/(^[a-zA-Z]{3}-[0-9]{1,4}$)/.test(validateValue)) )) {
            selectedInputElem.addClass('is-invalid text-danger');
            selectedInputElem.focus();
            selectedInputElem.next().next().removeClass('d-none');
            return false;
          } else {
            selectedInputElem.removeClass('is-invalid text-danger').addClass('is-valid text-success');
            selectedInputElem.next().next().addClass('d-none');
            return true;
          }
        } else { // validateAllLine (allLine is chedcked)
          selectedInputElem.removeClass('is-invalid text-danger is-valid text-success');
          selectedInputElem.next().next().addClass('d-none');
          return true;
        }
      }

      // console.log($('[name="selectedCauses[]"]').select2('data'));
    });
    // /.Event click submit

    // Event click tab
    let selectedTabs = Array.from(document.querySelectorAll('[data-toggle="tab"]'));
    selectedTabs = selectedTabs.map(selectedTab => selectedTab.addEventListener('click', () => {
      if ($('.collapsed-card').length) {
        $('[data-card-widget="collapse"]').click();
      }
    }));
    // /.Event click tab
    
    // Utility function
    function compare(a, b) {
      // Use toUpperCase() to ignore character casing
      const idA = a.id.toUpperCase();
      const idB = b.id.toUpperCase();
    
      let comparison = 0;
      if (idA > idB) {
        comparison = 1;
      } else if (idA < idB) {
        comparison = -1;
      }
      return comparison;
    }

    // Initialize DataTable
    function createDataTable() {
      jQuery.fn.DataTable.Api.register( 'buttons.exportData()', function ( options ) {
        if ( this.context.length ) {
            let jsonResult = $.ajax({
                url: './api/search-line-index-api.php',
                data: getFormValue(),
                success: function (result) {
                    //Do nothing
                },
                async: false
            });

            return {body: JSON.parse(jsonResult.responseText).data, header: $("#outageTable thead tr th").map(function() { return this.innerHTML; }).get()};
        }
      } );

      table = $("#outageTable").DataTable({ // table as global variable
        responsive: true,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
          url: './api/search-line-index-api.php',
          type: "GET",
          data: function(d) {
            let {lineName, selectedCause, intType, dateFrom, dateTo} = getFormValue();
            (typeof lineName !== 'undefined') ? d.lineName = lineName : null;
            (typeof selectedCause !== 'undefined') ? d.selectedCause = selectedCause : null;
            d.intType = intType;
            d.dateFrom = dateFrom;
            d.dateTo = dateTo;
          }
        },
        drawCallback: function( settings ) {
          let api = this.api();
          updateCaption({numRows: api.rows().count()});

          //Remove overlay card
          $('.overlay').addClass('d-none');
        },
        dom: "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'rt>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        lengthMenu: [
          [ 10, 25, 50, -1 ],
          [ '10 แถว', '25 แถว', '50 แถว', 'ทั้งหมด' ]
        ],
        buttons: [
          'pageLength', 'copy', {
            extend: 'csv',
            bom: true,
          }, 'excel'
        ],
        language: {
          url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Thai.json',
          buttons: {
            pageLength: {
              _: 'แสดง %d แถว',
              '-1': 'แสดงทั้งหมด'
            },
            copy: 'คัดลอก',
            copyTitle: 'คัดลอกข้อมูลไปยังคลิปบอร์ด',
            copySuccess: {
              _: 'คัดลอก %d แถวไปยังคลิปบอร์ด'
            } 
          }
        },
      });
    }

    function updateCaption({numRows}) {
      let selectedForm = activeFormElems.filter(activeFormElem => activeFormElem.attr('class').includes('active'))
      if (selectedForm[0].attr('id') === 'line') {
        let {lineName, dateFrom, dateTo} = getFormValue();
        lineName = (lineName === 'allLine') ? 'ทุกสายส่ง' : lineName;
        if (numRows) {
          $('caption').text(`สถิติไฟฟ้าดับสายส่ง ${lineName} วันที่ ${moment(dateFrom).format('ll')} ถึงวันที่ ${moment(dateTo).format('ll')}`);
        } else {
          $('caption').text(`ไม่พบ สถิติไฟฟ้าดับสายส่ง ${lineName} วันที่ ${moment(dateFrom).format('ll')} ถึงวันที่ ${moment(dateTo).format('ll')}`);
        }
      } else { // id='cause' 
        let {dateFrom, dateTo} = getFormValue();
        if (numRows) {
          $('caption').text(`สถิติไฟฟ้าดับจากสาเหตุที่เลือก วันที่ ${moment(dateFrom).format('ll')} ถึงวันที่ ${moment(dateTo).format('ll')}`);
        } else {
          $('caption').text(`ไม่พบ สถิติไฟฟ้าดับจากสาเหตุที่เลือก วันที่ ${moment(dateFrom).format('ll')} ถึงวันที่ ${moment(dateTo).format('ll')}`);
        }
      }
    }

    function getFormValue() {
      let intType = interruptionType[parseInt($("input[name='radioIntType']:checked").val())];
      let dateTempArr = $("#datetimepickerFrom").val().split(" ");
      let dateFrom = moment([parseInt(dateTempArr[2]), monthNumber[dateTempArr[1]]-1, parseInt(dateTempArr[0])]).format('YYYY-MM-DD');
      dateTempArr = $("#datetimepickerTo").val().split(" ");
      let dateTo = moment([parseInt(dateTempArr[2]), monthNumber[dateTempArr[1]]-1, parseInt(dateTempArr[0])]).format('YYYY-MM-DD');

      let selectedForm = activeFormElems.filter(activeFormElem => activeFormElem.attr('class').includes('active'))
      if (selectedForm[0].attr('id') === 'line') {
        let lineName;
        if (selectedForm[0].find('#allLine').is(':checked')) { // allLine is checked
          lineName = 'allLine';
        } else { // allLine isn't checked but input has line name
          lineName = $("input[name='lineName']").val();
        }
        return {lineName, intType, dateFrom, dateTo};
      } else { // id='cause'
        let selectedCauses = $('[name="selectedCauses[]"]').select2('data');
        let selectedCause = selectedCauses.map(selectedCause => selectedCause.id);
        return {selectedCause, intType, dateFrom, dateTo};
      }
    }
    // /.Utility function
});