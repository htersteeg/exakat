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


namespace Report\Content;

class Compilations extends \Report\Content {
    private $versions = array();

    public function collect() {
        $queryTemplate = "g.V.has('atom', 'File').count()";
        $res = gremlin_query($queryTemplate);
        $total = $res->results[0];
        
        foreach($this->versions as $suffix) {
            $files = \Analyzer\Analyzer::$datastore->getCol('compilation'.$suffix, 'file');
            $version = substr($suffix, 0, 1).'.'.substr($suffix, 1);
            if (empty($files)) {
                $files       = 'No compilation error found.';
                $errors      = 'N/A';
                $total_error = 'None';
            } else {
                $errors      = array_count_values(\Analyzer\Analyzer::$datastore->getCol('compilation'.$suffix, 'error'));
                $errors      = array_keys($errors);
                $errors      = array_keys(array_count_values($errors));

                $total_error = count($files).' (' .number_format(count($files) / $total * 100, 0). '%)';
                $files       = array_keys(array_count_values($files));
            }
            
            $array = array('version'       => $version,
                           'total'         => $total,
                           'total_error'   => $total_error,
                           'files'         => $files,
                           'errors'        => $errors,
                           );

            $this->array[] = $array;
        }
        
        return true;
    }
    
    public function setVersions($versions) {
        $this->versions = $versions;
    }
}

?>
