<?php

/** Copyright (C) 2013-2014  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
$envConfiguration = array_merge(
    array(
        'databaseHost' => 'localhost',
        'databaseName' => 'esta',
        'databaseUsername' => 'esta',
        'databasePassword' => 'esta',
        'databasePort' => '3306',
        'languages'=>array('de'=>'Deutsch','en'=>'Englisch'),
    ),
    @parse_ini_file(__DIR__ . '/../../.env') ?: [],
    @parse_ini_file(__DIR__ . '/../../.env.local') ?: []
);

return $envConfiguration;
