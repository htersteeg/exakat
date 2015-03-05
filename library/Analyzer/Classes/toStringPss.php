<?php
/*
 * Copyright 2012-2015 Damien Seguy – Exakat Ltd <contact(at)exakat.io>
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


namespace Analyzer\Classes;

use Analyzer;

class toStringPss extends Analyzer\Analyzer {
    public function analyze() {
        $methods = $this->loadIni('php_magic_methods.ini', 'magicMethod');
        $methods = array_diff($methods, array('__construct', '__destruct'));
        
        $this->atomIs('Function')
             ->hasClass()
             ->outIs('NAME')
             ->code($methods)
             ->inIs('NAME')
             ->hasOut('STATIC')
             ->back('first');
        $this->prepareQuery();

        $this->atomIs('Function')
             ->hasClass()
             ->outIs('NAME')
             ->code($methods)
             ->inIs('NAME')
             ->hasOut(array('PRIVATE', 'PROTECTED'))
             ->back('first');
        $this->prepareQuery();
    }
}

?>
