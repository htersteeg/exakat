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

namespace Exakat\Analyzer\Cakephp;

use Exakat\Analyzer\Analyzer;

class Cake33DeprecatedStaticmethodcall extends Analyzer {
    public function analyze() {
        $staticcalls = array('\cake\routing\router' => array('mapResources', 'redirect', 'parseNamedParams'));

        $methodcalls = array(array('statusCode', 'encoding', 'header', 'cookie', 'version'), //'\cake\http\client\response'
                            ); 

        $deprecatedClasses = array('\cake\utility\crypto\mcrypt',
                                  );

        $deprecatedInterface = array(
                                    );
        
        $deprecatedTrait = array('\cake\routing\requestactiontrait', //'RequestActionTrait'
                                );

        // Static methods calls
        foreach($staticcalls as $class => $methods) {
            $this->atomIs('Staticmethodcall')
                 ->outIs('CLASS')
                 ->fullnspathIs($class)
                 ->inIs('CLASS')
                 ->outIs('METHOD')
                 ->atomIs('Identifier')
                 ->codeIs($methods)
                 ->back('first');
            $this->prepareQuery();
        }

        // Classes
        $this->atomIs('Class')
             ->fullnspathIs($deprecatedClasses);
        $this->prepareQuery();

        // Interfaces
        $this->atomIs('Class')
             ->fullnspathIs($deprecatedClasses);
        $this->prepareQuery();

        // Classes
        $this->atomIs('Class')
             ->fullnspathIs($deprecatedClasses);
        $this->prepareQuery();
    }
}

?>