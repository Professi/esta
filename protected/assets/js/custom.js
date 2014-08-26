;
(function(window, document, $) {
    
        // http://stackoverflow.com/questions/654112/how-do-you-detect-support-for-vml-or-svg-in-a-browser
        // http://forum.jquery.com/topic/add-svg-support-verification-do-jquery-support
        function supportsSvg() {
            var bool = false;
            if (document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#BasicStructure", "1.1") 
                    || document.implementation.hasFeature("http://www.w3.org/TR/SVG11/feature#Shape", "1.0") ) {
                        bool = true;
                    }
            return bool;
        }
        
        // ** JQuery UI Autocomplete Einstellungen **    
        
        function blockDefaultAction(e) {
            e.preventDefault();
        }
            // ** Seite: appointment/create.php **
        
    $('input[id$="_display"]').on('autocompletefocus', function(e) {
        blockDefaultAction(e);
    });
        
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
               $('#appointment_dateAndTime_select').children('select').select2();
           }, 'json'); 
        });
        
        $('#appointmentBlock_teacher').on('autocompleteselect', function (e, ui) {
           blockDefaultAction(e);
           $(this).val(ui.item.label);
           $(this).nextAll('input').val(ui.item.value);
           $.get('index.php/?r=appointment/getteacherappointmentsajax', {teacherId: ui.item.value, classname: 'BlockedAppointment'}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
               $('#appointment_dateAndTime_select').children('select').select2();
           }, 'json'); 
        });        
        
    $('input[id$="_teacher"]').on('autocompletefocus', function(e) {
        blockDefaultAction(e);
    });
       
        $('#appointment_parent').on('autocompleteselect', function(e, ui) {
           blockDefaultAction(e);
           $(this).val(ui.item.label);
           $.get('index.php/?r=appointment/getselectchildrenajax', {id: ui.item.value}, function(data) {
              $('#appointment_parent_select').html(data);
              $('#appointment_parent_select').children('select').select2();
           }, 'json');
        });
        
    $('#appointment_parent').on('autocompletefocus', function(e) {
        blockDefaultAction(e);
    });
        
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
    }
    ;
        
        $('input[id$="_lockAt"]').on({
        change: function() {
            changeLockAtContent();
        },
        keyup: function() {
            changeLockAtContent();
        }
        });
        
        // ** Daten von Time, DateFormat in das kombinierte Feld eintragen **
        
        $('input[id$="_dateFormat"], input[id$="_timeFormat"]').on('keyup', function() {
           $('#ConfigForm_dateTimeFormat').val($('input[id$="_dateFormat"]').val()+' '+$('input[id$="_timeFormat"]').val());
        });
        
        // ** Felder in Config ein-, ausschalten **
        
        $('select[id$="_allowBlockingAppointments"], select[id$="_banUsers"], select[id$="_mailsActivated"]').on('change', function(event) {
            $switch = (event.target['value'] === "0") ? true : false;
            $(event.target).parents('fieldset').children('.row:gt(0)').children('.four').children('input, select').attr('disabled',$switch);
        });
        
        $('select[id$="_randomTeacherPassword"]').on('change', function(event) {
            $switch = (event.target['value'] === "0") ? false : true;
            $('input[id$="_defaultTeacherPassword"]').attr('disabled', $switch);
        });
        
        // ** Infofelder generieren **
        
        $('.infolabel').each(function() {
            $(this).html($(this).html()+'&nbsp;&nbsp;<span data-icon="&#xe012;"/>');
        });
        
        $('.infofeld').on({
            mouseenter: function(){
                $('.infobox').show();
                $('.infobox').children('p').html($(this).siblings('.infotext').html());
                $('.infobox').css('left', $(document).width()/2-200);
                $('.infobox').css('top', $(window).height()/4);
            },
            mouseleave: function(){
                var that = $(event.toElement),
                    infobox = $('.infobox').get(0);
                if(infobox === that.get(0) || $.contains(infobox,that)) {
                    $(infobox).one('mouseleave',function() {
                        $(infobox).fadeOut('fast');
                    });
                } else {
                    $(infobox).fadeOut('fast');
                }
            }
        });
        
        $(document).ready(function() {
            // ** Elterntagfeld lockAt mit Daten aus dem hidden input füllen. **
            if ($('#lockAt_value').val() !== "" && typeof $('#lockAt_value').val() === 'string') {
               $value = $('#lockAt_value').val();
               $arr = $value.split(' ');
               $('#date_lockAt').val($arr[0]);
               $('#time_lockAt').val($arr[1]);
            }
            // ** Wenn der Browser SVG unterstützt die PNGs ersetzen. **
            if (supportsSvg()) {
                $('.view').children().each(function(){$(this).attr('src',path+'/img/search.svg');});
                $('.update').children().each(function(){$(this).attr('src',path+'/img/pencil.svg');});
                $('.delete').children().each(function(){$(this).attr('src',path+'/img/remove.svg');});
            }
            
        });
        
        // ** Gruppenauswahl deaktivieren wenn ein zu erstellender Benutzer nicht die Rolle Eltern hat. **
        
        $('#User_role').on('change', function(event) {
           if (event.val > 1) {
               $('#groups-select').select2("enable", true);
           } else {
               $('#groups-select').select2("enable", false);
               $('#groups-select').select2("val","");
           }
        }); 
        
        //** Mehr Felder für die Eingabe von Schülern zu TANs generieren. **
        
        var tanGensId = 0;
        
        $('.add-child-tan').on('click', function() {
            tanGensId++;
            $div = $('.customChild:first').clone();
            $($div).children().each(function() {
               $input = $(this).find('input');
               $select = false;
               if ($input.hasClass('select2-focusser')) {
                   $input = $(this).find('select');
                   $select = true;
               } 
               if ($input.length !== 0) {
                    $($input).attr('name', $($input).attr('name').replace(/\d/, tanGensId));
                    $($input).attr('id', $($input).attr('id').replace(/\d/, tanGensId));
                    $($input).val('');
               }
               if ($select) {
                   $($input).attr('tabindex','');
                   $($input).attr('class','');
                   $(this).children('.nine').html($input);
               }
            });
            $('.customChild:last').after($($div));
            $($div).find('select').select2();
        });
        
        // ** Druckansicht Link und Autocompletes **
        
        $('#print-view-teacher').on('autocompleteselect', function( e, ui ) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).data('id',ui.item.value);
        });
        
        $('#print-view-button').click(function() {
            var date = $('#print-view-date').val();
            var id = $('#print-view-teacher').data('id');
            if(date !== '' && typeof date === 'string' && id !== '' && typeof id === 'string') {
                window.location.href = "index.php?r=appointment/overview&id=" + id + "&date=" + date;
            }
        });
        
        // ** Gruppenzuweisung unter group/assign **
        
        var assignedGroups = [],
            groupsCount = 0;
        function AssignedGroup(group,user) {
            this.group = group;
            this.user = user;
        };
        
        function deleteGroupAssignment(e) {
            var tr = $(this).parents('tr'),
                user = tr.find('.group-user').val(),
                group = tr.find('.group-id').val(),
                select2Menu = e.data.param1,
                id = -1;
            $.each(assignedGroups,function(index) {
               if(this.group === group && this.user === user) {
                   id = index;
               }
            });    
            assignedGroups.splice(id,1);
            tr.remove();
            if(select2Menu.select2('open')) {
                select2Menu.select2('close');
            } else {
                select2Menu.select2('close');
                select2Menu.select2('open');
            }
        }
        
        $.each($('#date-form table #input-target').children(),function() {
            var user = $(this).find('.group-user').val(),
                group = $(this).find('.group-id').val(),
                assignment = new AssignedGroup(group,user);
                assignedGroups.push(assignment);
                groupsCount++;
            
        });
        
        
        $('#group-users').on('select2-selecting', function(e) {
            var groupSrc = $('#groups'),
                groupId = groupSrc.val(),
                newGroupAssignment = new AssignedGroup(groupId,e.val),
                alreadySelected = false;
            
            $.each(assignedGroups,function() {
                if(this.group === newGroupAssignment.group && this.user === newGroupAssignment.user) {
                    alreadySelected = true;
                }
            });
                
            if( ! alreadySelected) {
                var that = $(this),
                    tdUser = $('<td/>').text($(this).find('option[value=' + e.val + ']').text()),
                    tdGroup = $('<td/>').text(groupSrc.select2('data').text),
                    template = $('#input-template'),
                    inputUser = template
                        .find('.group-user')
                        .clone()
                        .attr('name','user[' + groupsCount + ']')
                        .val(newGroupAssignment.user),
                    inputGroup = template
                        .find('.group-id')
                        .clone()
                        .attr('name','group[' + groupsCount + ']')
                        .val(newGroupAssignment.group),
                    checkBoxGroup = template
                        .find('.group-delete')
                        .clone()
                        .attr('name','group[' + groupsCount + ']'),
                    span = template
                        .find('span')
                        .clone()
                        .click({param1:that},deleteGroupAssignment);

                tdUser.append(inputUser);
                tdGroup.append(inputGroup).append(checkBoxGroup);

                $('<tr/>')
                        .append(tdUser)
                        .append(tdGroup)
                        .append($('<td/>',{class:'text-center'}).append(span))
                        .appendTo($('#input-target'));
                
                assignedGroups.push(newGroupAssignment);
                groupsCount++;
            }

            event.preventDefault();
            e.preventDefault();
            
            that.select2('close');
            that.select2('open');
                
        });
        
        $('#close-user-select').on('click',function() {
                $('#group-users').select2('close');
        });
        
        $('.flag-relation-for-delete').click(function() {
            var tr = $(this).parents('tr');
            tr.find('.group-delete').click();
            tr.toggleClass('delete-assign');
        });
        
        // ** Filesizelimit in importTeacher
        
        $('#CsvUpload_file').on('change',function() {
            if(this.files[0].size > maxFileSize) {
                alert(errorMessage);
                $(this).val('');
            }
        });

    }(this, document, jQuery));