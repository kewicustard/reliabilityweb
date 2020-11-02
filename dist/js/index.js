$(document).ready(function(){
    
    displayHilightMenu('dashboard');

    $.get('api/index-api.php', (res, status) => {
        // Change Content Header Text
        $('div.container-fluid').find('h1').text('สรุปคะแนนดัชนีฯ ตามตัวชี้วัดต่างๆ (สะสมถึง ' + fullThaiMonth[res.lasted_month] + ' ' + (Number(res.lasted_year)+543) + ')')

        // Remove All Overlay Loading
        $('.overlay').remove();

        // MEA Strategy Card
        manipulateCard({
            cardId: '#strategy-card',
            hasTarget: res.strategyHasTarget,
            saifi_kpi: res.saifi_kpi,
            saidi_kpi: res.saidi_kpi,
            lasted_year: res.lasted_year
        });
        // /.MEA Strategy Card

        // MEA SEPA Card
        manipulateCard({
            cardId: '#sepa-card',
            hasTarget: true,
            saifi_kpi: res.saifi_kpi_sepa,
            saidi_kpi: res.saidi_kpi_sepa
        });
        // /.MEA SEPA Card

        // MEA SEPA Focus Group Card
        manipulateCard({
            cardId: '#sepa-focus-group-card',
            hasTarget: true,
            saifi_kpi: res.saifi_kpi_focus,
            saidi_kpi: res.saidi_kpi_focus
        });
        // /.MEA SEPA Focus Group Card
    })
  
    manipulateCard = ({cardId, hasTarget, saifi_kpi, saidi_kpi, ...rest}) => {
        {}
        let strategyCard = $(cardId);
        // strategyCard.children("div.card").removeClass('card-secoondary');
        let strategySaifiBox = strategyCard.find('div.small-box').first();
        let strategySaidiBox = strategyCard.find('div.small-box').last();
        if (hasTarget) {// strategyHasTarget = true
            // saifi
            if (Number(saifi_kpi) >= 5) {
                strategySaifiBox.removeClass('bg-light').addClass('bg-olive');
                strategySaifiBox.find('h3').text(saifi_kpi);
                strategySaifiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-happy-outline');
            } else {
                strategySaifiBox.removeClass('bg-light').addClass('bg-danger');
                strategySaifiBox.find('h3').text(saifi_kpi);
                strategySaifiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-sad-outline');
            }
            // saidi
            if (Number(saidi_kpi) == 5) {
                strategySaidiBox.removeClass('bg-light').addClass('bg-olive');
                strategySaidiBox.find('h3').text(saidi_kpi);
                strategySaidiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-happy-outline');
            } else {
                strategySaidiBox.removeClass('bg-light').addClass('bg-danger');
                strategySaidiBox.find('h3').text(saidi_kpi);
                strategySaidiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-sad-outline');
            }
        } else {// strategyHasTarget = false
            // saifi
            if (Number(saifi_kpi) == 5) {
                strategySaifiBox.removeClass('bg-light').addClass('bg-olive');
                strategySaifiBox.find('h3').text('ดีกว่าปี ' + (Number(rest.lasted_year)-1+543));
                strategySaifiBox.find('p').text('SAIFI');
                strategySaifiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-happy-outline');
            } else {
                strategySaifiBox.removeClass('bg-light').addClass('bg-danger');
                strategySaifiBox.find('h3').text('สูงกว่าปี ' + (Number(rest.lasted_year)-1+543));
                strategySaifiBox.find('p').text('SAIFI');
                strategySaifiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-sad-outline');
            }
            // saidi
            if (Number(saidi_kpi) == 5) {
                strategySaidiBox.removeClass('bg-light').addClass('bg-olive');
                strategySaidiBox.find('h3').text('ดีกว่าปี ' + (Number(rest.lasted_year)-1+543));
                strategySaidiBox.find('p').text('SAIDI');
                strategySaidiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-happy-outline');
            } else {
                strategySaidiBox.removeClass('bg-light').addClass('bg-danger');
                strategySaidiBox.find('h3').text('สูงกว่าปี ' + (Number(rest.lasted_year)-1+543));
                strategySaidiBox.find('p').text('SAIDI');
                strategySaidiBox.find('i.ion').removeClass('ion-help-circled').addClass('ion-sad-outline');
            }
        }
    }
});

