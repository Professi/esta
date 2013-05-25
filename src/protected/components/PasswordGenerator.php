<?php

/**
 * Passwortgenerator
 */
/* * Copyright (C) 2013  Christian Ehringfeld, David Mock, Matthias Unterbusch
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
class PasswordGenerator {

    /**
     * generates a passsword
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param int $length lengths of password
     * @return string a password
     */
    public function generate($length = 8) {
        $password = "";
        $a_letters = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
            'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
        $a_special = array('!', '$', '%', '&', '/', '(', ')', '=', '?', '@', '-');
        for ($i = 0; $i < $length; $i++) {
            $chose = mt_rand(0, 2);
            $char = '';
            switch ($chose) {
                case 0:
                    $char = mt_rand(0, 9);
                    break;
                case 1:
                    $char = $this->choseChar($a_letters);
                    $up = mt_rand(0, 1);
                    if ($up == 1) {
                        $char = ucfirst($char);
                    }
                    break;
                case 2:
                    $char = $this->choseChar($a_special);
                    break;
            }
            $password .= $char;
        }
        return $password;
    }

    /**
     * chosing a character from array, if array empty returns false
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param array $array
     * @return boolean/char 
     */
    private function choseChar($array) {
        $rc = '';
        if (count($array) > 0) {
            $rc = $array[mt_rand(0, count($array) - 1)];
        } else {
            $rc = false;
        }
        return $rc;
    }

    /**
     * generates passwords
     * @author Christian Ehringfeld <c.ehringfeld@t-online.de>
     * @param int $length length of one password
     * @param int $count number of passwords
     * @return array
     */
    public function generateMore($length = 8, $count = 1) {
        $rc = array();
        for ($i = 0; $i < $count; $i++) {
            $rc[] = $this->generate($length);
        }
        return $rc;
    }

}

?>
