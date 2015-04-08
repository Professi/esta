(function($) {
    $(document).ready(function(){
        
        $(document).foundation();
        
        $('#LoginForm_email').focus();
        
        $('.js_show').toggle();
        $('.js_hide').toggle();
        
        $('#language-selector').parent().clone().appendTo($('.top-bar .left'));
        
        $(document).keyup(function(e) {
            if(e.keyCode === 27) {
                $('.ul-nav-toggle').click();
            }
        });
        
        // ** AJAX Handler 
        
        var useAjax = function (data,statusElement,elementsToClear) {
            var valid = true,
                statusButton = statusElement.find('div.button'),
                statusMessage = statusElement.find('input');
            $.each(data,function(key,value) {
                if (value === undefined) {
                    valid = false;
                }
            })
            if ( ! valid) {
                alert(msg_ajax_param_empty);
                return;
            }
            
            statusButton.removeClass('success alert secondary').addClass('secondary').find('i').attr('class','fi-upload-cloud');
            statusMessage.val('');
            $.ajax({
                url: 'index.php',
                method: 'GET',
                data: data
            }).done(function( data ) {
                try {
                    answer = JSON.parse(data);
                } catch (e) {
                    statusButton.removeClass('secondary').addClass('alert').find('i').attr('class','fi-alert');
                    statusMessage.val(e);
                }
                console.log(answer);
                if (answer.status) {
                    statusButton.removeClass('secondary').addClass('success').find('i').attr('class','fi-check');
                    $.each(elementsToClear,function(key,input) {
                        input.val('');
                        input.data('id','');
                    });
                } else {
                    statusButton.removeClass('secondary').addClass('alert').find('i').attr('class','fi-alert');
                }
                statusMessage.val(answer.msg);
            }).fail(function( jqXHR, textstatus) {
                statusButton.removeClass('secondary').addClass('alert').find('i').attr('class','fi-alert');
                statusMessage.val(textstatus);
            });
        }
        
        // ** Icon to minimize the nav **
        
        $('.sticky').append($('<i/>',{'class':'fi-eye ul-nav-toggle',text:' Menu'}));
        
        $('.ul-nav li').click(function() {
            if($(this).find('#language-selector').length === 0) {
                window.location = $(this).find('a').attr('href');
            }
        });
        
        $('.ul-nav-toggle').click(function() {
            var that = $(this);
            that.siblings('ul').toggleClass('ul-nav ul-nav-hide');
        }).click();
        
        // ** Terminvereinbarung **
        
        $('#teacher-ac').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            window.location.href = "index.php?r=Appointment/makeAppointment&teacher=" + ui.item.value;
        });
        
        $('.avaiable').css('cursor', 'pointer');
        $('.appointment-create-table .avaiable').click(function() {
                var that = $(this);
                $('#form_date').val(that.parents('table').data('date'));
                $('#form_time').val(that.siblings().text().trim());
                $('select[name*="dateAndTime_id"]').select2('val',that.data('id'));
        });
        
        // ** Löschabfragen **
        
        $('.delete-children').click(function() {
           if (!confirm(msg_delete_children)) {
               return false;
           }
        });
        
        $('.delete-appointment').click(function() {
           if (!confirm(msg_delete_appointment)) {
               return false;
           } 
        });
        
        // ** Infofelder generieren **
        
        $('.infolabel').each(function() {
            $(this).append($('<i/>',{'class':'fi-info'}));
        });
        
        $('.infofeld').click(function(e) {
                e.preventDefault();
                $('.infobox').show();
                $('.infobox').children('p').html($(this).siblings('.infotext').html());
                $('.infobox').css('left', $(document).width()/2-200);
                $('.infobox').css('top', $(window).height()/4);
                e.stopPropagation();
                $(document).one('click',function() {
                    $('.infobox').hide();
                });
        });
        
        // ** Filesizelimit in importTeacher
        
        $('#CsvUpload_file').on('change',function() {
            if(this.files[0].size > maxFileSize) {
                alert(errorMessage);
                $(this).val('');
            } else {
                $('#file-input-name').val(this.files[0].name);
            }
        });
        
        // ** Elterntagfeld lockAt mit Daten aus dem hidden input füllen. **
        
        if ($('#lockAt_value').val() !== "" && typeof $('#lockAt_value').val() === 'string') {
           var value = $('#lockAt_value').val(),
               arr = value.split(' ');
           $('#date_lockAt').val(arr[0]);
           $('#time_lockAt').val(arr[1]);
        }  
        
        // ** Gruppenauswahl deaktivieren wenn ein zu erstellender Benutzer nicht die Rolle Eltern hat. **
        
        $('#User_role').on('change', function(event) {
           if (event.val > 1) {
               $('#groups-select').select2("enable", true);
           } else {
               $('#groups-select').select2("enable", false);
               $('#groups-select').select2("val","");
           }
        });
        
        // ** Felder in Config ein-, ausschalten **
        
        $('select[id$="_allowBlockingAppointments"], select[id$="_banUsers"], select[id$="_mailsActivated"]').on('change', function(event) {
            var flip = (event.target['value'] === "0") ? true : false;
            $(event.target).parents('fieldset').children('.row:gt(0)').children('.small-4').children('input, select').attr('disabled',flip);
        });
        
        $('select[id$="_randomTeacherPassword"]').on('change', function(event) {
            var flip = (event.target['value'] === "0") ? false : true;
            $('input[id$="_defaultTeacherPassword"]').attr('disabled', flip);
        });
        
        // ** Daten von Time, DateFormat in das kombinierte Feld eintragen **
        
        $('input[id$="_dateFormat"], input[id$="_timeFormat"]').on('change', function() {
           $('#ConfigForm_dateTimeFormat').val($('input[id$="_dateFormat"]').val()+' '+$('input[id$="_timeFormat"]').val());
        });
        
        // ** Daten von lockAt in das entsprechende Feld eintragen **

        function changeLockAtContent() {
            $('#lockAt_value').val($('input[id$="_lockAt"]')[0]['value']+' '+$('input[id$="_lockAt"]')[1]['value']);
        }
        
        $('input[id$="_lockAt"]').on({
        change: function() {
            changeLockAtContent();
        },
        keyup: function() {
            changeLockAtContent();
        }
        });
        
        // ** JQuery UI Autocomplete Einstellungen **    
                
        $('#teacher-ac,input[id$="_display"],input[id$="_teacher"],#appointment_parent,#print-view-teacher,#room-assign-teacher,#room-assign-room').on('autocompletefocus', function(e) {
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
           $.get('index.php/?r=appointment/getteacherappointmentsajax', {teacherId: ui.item.value, classname: 'Appointment'}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
               $('#appointment_dateAndTime_select').children('select').select2();
           }, 'json'); 
        });
        
        $('#appointmentBlock_teacher').on('autocompleteselect', function (e, ui) {
           e.preventDefault();
           $(this).val(ui.item.label);
           $(this).nextAll('input').val(ui.item.value);
           $.get('index.php/?r=appointment/getteacherappointmentsajax', {teacherId: ui.item.value, classname: 'BlockedAppointment'}, function(data) {
               $('#appointment_dateAndTime_select').html(data);
               $('#appointment_dateAndTime_select').children('select').select2();
           }, 'json'); 
        });        
        
        $('#appointment_parent').on('autocompleteselect', function(e, ui) {
           e.preventDefault();
           $(this).val(ui.item.label);
           $.get('index.php/?r=appointment/getselectchildrenajax', {id: ui.item.value}, function(data) {
              $('#appointment_parent_select').html(data);
              $('#appointment_parent_select').children('select').select2();
           }, 'json');
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
        
        $('#print-view-all-button').click(function() {
            var date = $('#print-view-date').val();
            var empty = ($('#show-empty-plans').is(':checked') ? 1 : 0);
            if(date !== '' && typeof date === 'string') {
                window.location.href = "index.php?r=appointment/generatePlans&date=" + date + "&emptyPlans=" + empty;
            }
        });
        
        // ** Lehrer Raum Verknüpfung AJAX und Autocompletes
        
        $('#room-assign-teacher').on('autocompleteselect', function( e, ui) {
            e.preventDefault();
            $(this).val(ui.item.label);
            $(this).data('id',ui.item.value);
        });
        
        $('#room-assign-button').on('click', function() {
            var teacher = $('#room-assign-teacher'),
                teacherId = teacher.data('id'),
                room = $('#room-assign-room'),
                roomValue = room.val(),
                date = $('#room-assign-date').val(),
                data = {'r':'room/assignajax','teacher':teacherId,'room':roomValue,'date':date},
                statusElement = $('#room-assign-status'),
                inputs = [teacher,room];
            useAjax(data,statusElement,inputs);
        });
        
        // ** Lehrer Raum Verknüpfung Stapelverarbeitung
        
        if (document.getElementById('room-assignall-workspace') !== null) {
            // Globalen
            var template = $('#room-assignall-template'),
                workspace = $('#room-assignall-workspace'),
                id = 0,
                date = $('#room-assignall-date');
            // Templates erstellen
            $.each(teachers, function(key,teacher) {
                var clone = template.clone(),
                    title = teacher.title !== null ? teacher.title + ' ' : '',
                    name = title + teacher.firstname + ' ' + teacher.lastname;
                id++;
                clone.attr('id','room-assignall-element.' + id);
                clone.find('#room-assignall-teacher').attr('id','room-assignall-teacher.' + id).data('id',teacher.id).val(name);
                clone.find('#room-assignall-room').attr('id','room-assignall-room.' + id);
                clone.find('#room-assignall-status').attr('id','room-assignall-status.' + id);
                workspace.prepend(clone);
            });
            // Stapelverarbeitung
            $('#room-assignall-button').click(function() {
                if ( ! confirm(msg_assignall_button + date.find('option:checked').text() + '?')) {
                    return;
                }
                workspace.find('div[id*="element."]').each(function(key,element) {
                    var teacher = $(element).find('input[id*="teacher."]'),
                        teacherId = teacher.data('id'),
                        room = $(element).find('input[id*="room."]'),
                        roomValue = room.val(),
                        data = {'r':'room/assignajax','teacher':teacherId,'room':roomValue,'date':date.val()},
                        statusElement = $(element).find('div[id*="status."]'),
                        inputs = [];
                    useAjax(data,statusElement,inputs); 
                });
            });
            // Fehler auffinden
            $('#room-assignall-errors').click(function() {
                $('html, body').animate({
                    scrollTop: $('.alert').first().offset().top + 100
                }, 1000);
            });
        }
        
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
                        .find('i')
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

    });
    
    
    //** Mehr Felder für die Eingabe von Schülern zu TANs generieren. **
        
    var tanGensId = 0;

    $('.add-child-tan').click(function() {
        tanGensId++;
        var div = $('.customChild:first').clone();
        $(div).children().each(function() {
           var input = $(this).find('input'),
               select = false;
           if (input.hasClass('select2-focusser')) {
               input = $(this).find('select');
               select = true;
           } 
           if (input.length !== 0) {
                $(input).attr('name', $(input).attr('name').replace(/\d/, tanGensId));
                $(input).attr('id', $(input).attr('id').replace(/\d/, tanGensId));
                $(input).val('');
           }
           if (select) {
               $(input).attr('tabindex','');
               $(input).attr('class','');
               $(this).children('.small-9').html(input);
           }
        });
        $('.customChild:last').after($(div));
        $(div).find('select').select2();
    });
        
})(jQuery);