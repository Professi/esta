<?php

/* * Copyright (C) 2014  Christian Ehringfeld, David Mock
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
 * Static Class to convert Bytes from php.ini
 *
 * @author cehringfeld
 */
class ByteConverter {

    private function __construct() {
        
    }

    /**
     * Konvertiert eine Datei in ISO-8859-1 in UTF-8
     * @param string $toEncode
     * @return string
     * 
     */
    static public function encodingString($toEncode, $to = 'UTF-8', $from = 'ISO-8859-1') {
        return mb_convert_encoding($toEncode, $to, $from);
    }

    /**
     * creates nicely formatted string from array
     * @param array $array
     * @return string
     */
    static public function convert_multi_array($array) {
        return implode("&", array_map(function($a) {
                    return implode("~", $a);
                }, $array));
    }

    static private function return_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        $val = substr($val, 0, strlen($val) - 1);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    static public function getMaxSizeInBytes() {
        return self::return_bytes(self::getMaxSize());
    }

    static public function getMaxSize() {
        return ini_get('post_max_size');
    }

}
