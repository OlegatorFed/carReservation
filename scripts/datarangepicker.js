function makeCalenar(elementName, from, to) {
    $('input[name='+ elementName +']').daterangepicker({
        minDate: from,
        maxDate: to,
        starDate: from,
        endDate: to,
        "opens": "center",
        "drops": "up",
        locale: {
            format: 'DD/MM/YYYY',
            "applyLabel": "Принять",
            "cancelLabel": "Отмена",
            "fromLabel": "От",
            "toLabel": "До",
            "daysOfWeek": [
                "Вс",
                "Пн",
                "Вт",
                "Ср",
                "Чт",
                "Пт",
                "Сб"
            ],
            "monthNames": [
                "Январь",
                "Февраль",
                "Март",
                "Апрель",
                "Май",
                "Июнь",
                "Июль",
                "Август",
                "Сентябрь",
                "Октябрь",
                "Ноябрь",
                "Декабрь"
            ],
            "firstDay": 1
        }
    });

    $('.cancelBtn').remove();
    $('.applyBtn').remove();
}