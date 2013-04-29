;(function(window, document, $) {     
        
        // ** JQuery UI Autocomplete Einstellungen **    
        
        function blockDefaultAction(e) {
            e.preventDefault();
        }
            // ** Seite: appointment/create.php **
        
        $('input[id$="_display"]').on('autocompletefocus', function(e){blockDefaultAction(e);});
        
        $('input[id$="_display"]').on('autocompleteselect', function(e, ui) {
            blockDefaultAction(e);
            $(this).val(ui.item.label);
            $(this).nextAll('input').val(ui.item.value);
        });
        
        $('#appointment_teacher').on('autocompleteselect', function (e, ui) {
           blockDefaultAction(e);
           $(this).val(ui.item.label);
           $(this).nextAll('input').val(ui.item.value);
           $.get('index.php/?r=appointment/getteacherappointmentsajax', {teacherId: ui.item.value, classname: 'Appointment'}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
           }, 'json'); 
        });
        
        $('#appointmentBlock_teacher').on('autocompleteselect', function (e, ui) {
           blockDefaultAction(e);
           $(this).val(ui.item.label);
           $(this).nextAll('input').val(ui.item.value);
           $.get('index.php/?r=appointment/getteacherappointmentsajax', {teacherId: ui.item.value, classname: 'BlockedAppointment'}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
           }, 'json'); 
        });        
        
        $('input[id$="_teacher"]').on('autocompletefocus', function(e){blockDefaultAction(e);});
       
        $('#appointment_parent').on('autocompleteselect', function(e, ui) {
           blockDefaultAction(e);
           $(this).val(ui.item.label);
           $.get('index.php/?r=appointment/getselectchildrenajax', {id: ui.item.value}, function(data) {
              $('#appointment_parent_select').html(data); 
           }, 'json');
        });
        
        $('#appointment_parent').on('autocompletefocus', function(e){blockDefaultAction(e);});
        
        // ** Funktionalität für den Roten Knopf unter 'Ihr Benutzerkonto' **
        
        $('#red-button').on('click', function(e) {
            blockDefaultAction(e);
            $answer = confirm('Alles löschen?');
            if ($answer) {
                window.location.href = "index.php?r=user/deleteAll";
            }
        });
        
        // ** Daten von lockAt in das entsprechende Feld eintragen **

        function changeLockAtContent() {
            $('#lockAt_value').val($('input[id$="_lockAt"]')[0]['value']+' '+$('input[id$="_lockAt"]')[1]['value']);
        };
        
        $('input[id$="_lockAt"]').on({
                change: function() {changeLockAtContent()},
                keyup: function() {changeLockAtContent()}
        });
        
        // ** Daten von Time, DateFormat in das kombinierte Feld eintragen **
        
        $('input[id$="_dateFormat"], input[id$="_timeFormat"]').on('keyup', function() {
           $('#ConfigForm_dateTimeFormat').val($('input[id$="_dateFormat"]').val()+' '+$('input[id$="_timeFormat"]').val());
        });
        
        // ** Felder in Config ein-, ausschalten **
        
        $('select[id$="_allowBlockingAppointments"], select[id$="_banUsers"], select[id$="_mailsActivated"]').on('change', function($this) {
            $switch = ($this.target['value'] === "0") ? true : false;
            $($this.target).parents('fieldset').children('.row:gt(0)').children('.four').children('input, select').attr('disabled',$switch);
        });
        
        // ** Infofelder generieren **
        
        $('.infolabel').each(function() {
            $(this).html($(this).html()+'&nbsp;&nbsp;<span data-icon="&#xe012;"/>');
        });
        
        $('.infofeld').on({
            mouseenter: function(){
                $('.infobox').toggle();
                $('.infobox').children('p').html($(this).siblings('.infotext').html());
                $('.infobox').css('left', $(document).width()/2-200);
                $('.infobox').css('top', $(window).height()/4);
            },
            mouseleave: function(){
                $('.infobox').toggle();
            }
            
        });

    }(this, document, jQuery));