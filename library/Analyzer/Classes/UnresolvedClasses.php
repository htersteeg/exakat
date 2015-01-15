<?php

namespace Analyzer\Classes;

use Analyzer;

class UnresolvedClasses extends Analyzer\Analyzer {
    public function dependsOn() {
        return array('Analyzer\\Classes\\IsExtClass',
                     'Analyzer\\Classes\\IsVendor',);
    }

    public function analyze() {
        $classes = $this->loadIni('php_classes.ini');
        $classes = $classes['classes'];
        $classes = $this->makeFullNsPath($classes);
        
        $this->atomIs("New")
             ->outIs('NEW')
             ->noClassDefinition()
             ->analyzerIsNot('Analyzer\\Classes\\IsExtClass')
             ->analyzerIsNot('Analyzer\\Classes\\IsVendor')
             ->fullnspathIsNot($classes);
        $this->prepareQuery();
        
        // also add property/constant/methods/catch/try/typehint
    }
}

?>
