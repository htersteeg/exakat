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


namespace Exakat\Analyzer\Structures;

use Exakat\Analyzer\Analyzer;

class ErrorMessages extends Analyzer {
    public function dependsOn() {
        return array('Exceptions/DefinedExceptions');
    }
    
    public function analyze() {
        $messages = array('String', 'Concatenation', 'Integer', 'Functioncall', 'Heredoc', 'Magicconstant');

        // die('true')
        // exit ('30');
        $this->atomFunctionIs(array('\\die', '\\exit'))
             ->outIs('ARGUMENTS')
             ->outWithRank('ARGUMENT', 0)
             ->atomIs($messages);
        $this->prepareQuery();

        //  new \Exception('Message');
        $this->atomIs('New')
             ->outIs('NEW')
             ->functioncallIs('\\exception')
             ->outIs('ARGUMENTS')
             ->outWithRank('ARGUMENT', 0)
             ->atomIs($messages);
        $this->prepareQuery();

        //  new $exception('Message');
        $this->atomIs('Throw')
             ->outIs('THROW')
             ->atomIs('New')
             ->outIs('NEW')
             ->atomIsNot('Functioncall')
             ->outIs('ARGUMENTS')
             ->outWithRank('ARGUMENT', 0)
             ->atomIs($messages);
        $this->prepareQuery();

        //  new myException('Message');
        $this->atomIs('New')
             ->outIs('NEW')
             ->tokenIs(array('T_STRING', 'T_NS_SEPARATOR'))
             ->isNot('fullnspath', null)
             ->_as('new')
             ->classDefinition()
             ->analyzerIs('Exceptions/DefinedExceptions')
             ->back('new')
             ->outIs('ARGUMENTS')
             ->outIs('ARGUMENT')
             ->atomIs($messages);
        $this->prepareQuery();
    }
}

?>
