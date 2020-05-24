<script>
    let $inputDate = $('#datepicker').pickadate({
        monthsFull: ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
        monthsShort: ['янв', 'фев', 'мар', 'апр', 'май', 'июн', 'июл', 'авг', 'сен', 'окт', 'ноя', 'дек'],
        weekdaysFull: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
        weekdaysShort: ['вс', 'пн', 'вт', 'ср', 'чт', 'пт', 'сб'],
        today: 'сегодня',
        clear: 'удалить',
        close: 'закрыть',
        firstDay: 1,
        hiddenName: true,
        format: 'd mmmm yyyy г.',
        formatSubmit: 'yyyy/mm/dd'
    });
    let pickerDate = $inputDate.pickadate('picker');
    let currentDate = $('#currentDate').val();
    pickerDate.set('select', new Date(currentDate));

    if ($('#timepicker').length) {
        let $inputTime = $('#timepicker').pickatime({
            hiddenName: true,
            format: 'H:i',
            clear: 'удалить'
        });
        let pickerTime = $inputTime.pickatime('picker');
        let currentTime = $('#currentTime').val();
        pickerTime.set('select', currentTime.split(':'));
    }
</script>