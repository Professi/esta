<?php

/* Copyright (C) 2013-2014  Christian Ehringfeld, David Mock
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
/**
 * @var $this AppointmentController
 * @var $pages [data,teacher,date]
 */

$count = count($pages);
foreach ($pages as $index => $page):
    if ($index !== 0):
       ?>
<div style="height: 3em;display:block;"></div>
<?php
    endif;
    echo $this->renderPartial('overview', array('data' => $page['data'],
        'teacher' => $page['teacher'],
        'room' => isset($page['room']) ? $page['room'] : null,
        'date' => $page['date']), true);
    if ($index !== $count): ?>
        <div class="page-break-after"></div>
<?php
    endif;
endforeach;
?>
<script>
    window.document.body.removeChild(window.document.getElementById('print-header'));
    window.onload = function(){window.print();};
</script>            

