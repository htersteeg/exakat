<?php
/*
 * Copyright 2012-2017 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
 * This file is part of Exakat.
 *
 * Exakat is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Exakat is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Exakat.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://exakat.io/>.
 *
*/


class Autoload {
    static public function autoload_library($name) {
        $file = __DIR__.'/'.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
        
        if (file_exists($file)) {
            include $file;
        } 
    }

    static public function autoload_test($name) {
        $path = dirname(__DIR__);
        
        $file = $path.'/tests/analyzer/'.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
        
        if (file_exists($file)) {
            include $file;
        } 

        $file = $path.'/tests/tokenizer/'.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
        
        if (file_exists($file)) {
            include $file;
        } 
    }

    static public function autoload_phpunit($name) {
        $file = 'Test/'.str_replace('_', '/', str_replace('Test\\', '', $name)).'.php';

        if (file_exists($file)) {
            include $file;
        }
    }
}

spl_autoload_register('Autoload::autoload_library');
require_once __DIR__.'/../vendor/autoload.php'; // depending on your project this may not be necessary

if (isset($argv)) {
    $config = \Exakat\Config::factory($argv);
} else {
    $config = \Exakat\Config::factory($GLOBALS['argv']);
}

include 'helpers.php';

?>