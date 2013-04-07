;// IE-Hack  http://stackoverflow.com/questions/2612026/disable-javascript-on-ie-browsers
var IE = /*@cc_on @if (@_jscript_version < 9){!}@*/false;
if (IE) {
} else {
    (function(window, document, $) {

        $('#LoginForm_email').focus();
        
        $('#js_menu').css('visibility', 'visible');
        $('#nojs_menu').css('display', 'none');
        $('.js_show').toggle();
        $('.js_hide').toggle();

        $(document).ready(function() {
            $('.button-group > li > a').addClass('small button');
            $('.button-group > li.disabled > a').addClass('disabled');
            $('#MenuModal').append($('.nojs_menu').clone()).html();
            $('#MenuModal ul').attr('class', 'nav-bar vertical');
            $('#MenuModal ul').attr('style', 'display:inherit;');
            $('#MenuModal').append('<a class="close-reveal-modal" data-icon="&#xe014;" style="color:#fff;"></a>');
        });
        
        // ** Funktionalität der Tabellen unter appointment/makeAppointment **
        
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
        
        // ** JQuery UI Autocomplete Einstellungen **
            // ** Seite: appointment/getTeacher.php **
        
        $('#teacher-ac').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            window.location.href = "index.php?r=Appointment/makeAppointment&teacher=" + ui.item.value;
        });
        
        $('#teacher-ac').on('autocompletefocus', function(e) {
           e.preventDefault(); 
        });
        
            // ** Seite: appointment/create.php **
        
        $('input[id$="_display"]').on('autocompletefocus', function(e) {
           e.preventDefault(); 
        });
        
        $('input[id$="_display"]').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).nextAll('input').val(ui.item.value);
        });
        
        $('#appointment_teacher').on('autocompleteselect', function (e, ui) {
           e.preventDefault();
           $(this).val(ui.item.label);
           $(this).nextAll('input').val(ui.item.value);
           $.get('index.php/?r=appointment/getteacherappointments', {teacherId: ui.item.value}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
           }, 'json'); 
        });
        
        $('#appointment_teacher').on('autocompletefocus', function(e) {
           e.preventDefault(); 
        });
        
        $('#appointment_parent').on('autocompleteselect', function(e, ui) {
           e.preventDefault();
           $(this).val(ui.item.label);
           $.get('index.php/?r=parentChild/searchcreateappointment', {term: ui.item.label.substr((ui.item.label.lastIndexOf(' '))+1)}, function(data) {
              $('#appointment_parent_select').html(data); 
           }, 'json');
        });
        
        $('#appointment_parent').on('autocompletefocus', function(e) {
            e.preventDefault();
        });
        
        // ** Funktionalität für den Roten Knopf unter 'Ihr Benutzerkonto' **
        $('#red-button').on('click', function(e) {
            e.preventDefault();
            $answer = confirm('Alles löschen?');
            if ($answer) {
                window.location.href = "index.php?r=user/deleteAll";
            }
        });
        
        // ** Daten von lockAt in das entsprechende Feld eintragen **
        $('input[id$="_lockAt"]').on('change', function() {
            $('#lockAt_value').val($('input[id$="_lockAt"]')[0]['value']+' '+$('input[id$="_lockAt"]')[1]['value']);
        });
        
    }(this, document, jQuery));
}
