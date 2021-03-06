<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Classes_EmptyClass extends Analyzer {
    /* 5 methods */

    public function testClasses_EmptyClass01()  { $this->generic_test('Classes_EmptyClass.01'); }
    public function testClasses_EmptyClass02()  { $this->generic_test('Classes_EmptyClass.02'); }
    public function testClasses_EmptyClass03()  { $this->generic_test('Classes_EmptyClass.03'); }
    public function testClasses_EmptyClass04()  { $this->generic_test('Classes_EmptyClass.04'); }
    public function testClasses_EmptyClass05()  { $this->generic_test('Classes/EmptyClass.05'); }
}
?>