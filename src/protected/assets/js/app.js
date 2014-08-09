;(function($, window, undefined) {
        'use strict';
        var $doc = $(document),
                Modernizr = window.Modernizr;
        $(document).ready(function() {
            $.fn.foundationAlerts ? $doc.foundationAlerts() : null;
            $.fn.foundationButtons ? $doc.foundationButtons() : null;
            $.fn.foundationAccordion ? $doc.foundationAccordion() : null;
            $.fn.foundationNavigation ? $doc.foundationNavigation() : null;
            $.fn.foundationTopBar ? $doc.foundationTopBar() : null;
            $.fn.foundationCustomForms ? $doc.foundationCustomForms() : null;
            $.fn.foundationMediaQueryViewer ? $doc.foundationMediaQueryViewer() : null;
            $.fn.foundationTabs ? $doc.foundationTabs({callback: $.foundation.customForms.appendCustomMarkup}) : null;
            $.fn.foundationTooltips ? $doc.foundationTooltips() : null;
            $.fn.foundationMagellan ? $doc.foundationMagellan() : null;
            $.fn.foundationClearing ? $doc.foundationClearing() : null;
            $.fn.placeholder ? $('input, textarea').placeholder() : null;
        });

        // UNCOMMENT THE LINE YOU WANT BELOW IF YOU WANT IE8 SUPPORT AND ARE USING .block-grids
        // $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
        // $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
        // $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
        // $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});

        // Hide address bar on mobile devices (except if #hash present, so we don't mess up deep linking).
        if (Modernizr.touch && !window.location.hash) {
            $(window).load(function() {
                setTimeout(function() {
                    window.scrollTo(0, 1);
                }, 0);
            });
        }

    })(jQuery, this);
    
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
        
        $('#teacher-ac').on('autocompleteselect', function(e, ui) {
            e.preventDefault();
            window.location.href = "index.php?r=Appointment/makeAppointment&teacher=" + ui.item.value;
        });
        
        $('#teacher-ac').on('autocompletefocus', function(e){e.preventDefault();});
        
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
            $('#MenuModal').append('<a class="close-reveal-modal close-reveal-modal-fix" data-icon="&#xe014;" style="color:#fff;"></a>');
            
            if (supportsSvg()) {
                $('.alarm_png').children().attr('src',path+'/img/alarm.svg');
            }
        });
        
        $('.avaiable').css('cursor', 'pointer');
        $('.avaiable').on('click', function() {
            $id = $(this).attr('id');
            $date = 'date-' + $id.substr(0, ($id.indexOf('_')));
            $time = 'time-' + $id;
            $date_text = $('#' + $date).text().match(/[^\s\(\)]+/);
            $time_text = $('#' + $time).text();
            $('#form_date').val($date_text);
            $('#form_time').val($time_text);
            $('#Appointment_dateAndTime_id').children('*:gt(0)').each(function(i, $this) {
                if ($($this).attr('label').match($date_text)) {
                    $($this).children().each(function(i, $this) {
                       if ($($this).text().match($time_text)) {
                           $this['selected'] = true;
                       }
                    });
                }
            });
        });
        
        $('.delete-children').on('click', function() {
           if (!confirm('Wenn Sie dieses Kind löschen werden auch alle Termine des Kindes gelöscht.')) {
               return false;
           }
        });
        
        $('.delete-appointment').on('click', function() {
           if (!confirm('Termin wirklich löschen?')) {
               return false;
           } 
        });
        
    }(this, document, jQuery));