;// IE-Hack  http://stackoverflow.com/questions/2612026/disable-javascript-on-ie-browsers
var IE = /*@cc_on @if (@_jscript_version < 9){!}@*/false;
if (IE) {
} else {
    (function(window, document, $) {

        $('#js_menu').css('visibility', 'visible');
        $('#nojs_menu').css('display', 'none');
        $('.js_show').toggle();
        $('.js_hide').toggle();

        $('.avaiable').css('cursor', 'pointer');
        $('.avaiable').on('click', function() {
            $id = $(this).attr('id');
            $date = 'date-' + $id.substr(0, ($id.indexOf('_')));
            $time = 'time-' + $id;
            $date_text = $('#' + $date).text();
            $time_text = $('#' + $time).text();
            $('#form_date').val($date_text);
            $('#form_time').val($time_text);
            $('#form_dateAndTime').children().each(function(i, $this) {
                $($this).children().each(function(i, $this) {
                    if ($($this).text().match($date_text + ' - ' + $time_text)) {
                        $this['selected'] = true;
                    };
                });
            });
        });

        $(document).ready(function() {
            $('.button-group > li > a').addClass('small button');
            $('.button-group > li.disabled > a').addClass('disabled');
            $('#MenuModal').append($('.nojs_menu').clone()).html();
            $('#MenuModal ul').attr('class', 'nav-bar vertical');
            $('#MenuModal ul').attr('style', 'display:inherit;');
            $('#MenuModal').append('<a class="close-reveal-modal" data-icon="&#xe014;" style="color:#fff;"></a>');
        });
        
        $('input[id$="_display"]').on('autocompletefocus', function(e, ui) {
           e.preventDefault(); 
        });
        
        $('input[id$="_display"]').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).nextAll('input').val(ui.item.value);
        });

        $('#teacher-ac').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            window.location.href = "index.php?r=Appointment/makeAppointment&teacher=" + ui.item.value;
        });
        
        $('#teacher-ac').on('autocompletefocus', function(e, ui) {
           e.preventDefault(); 
        });

        $('#red-button').on('click', function(e) {
            e.preventDefault();
            $answer = confirm('Alles löschen?');
            if ($answer) {
                window.location.href = "index.php?r=user/deleteAll";
            }
        });


    }(this, document, jQuery));
}
