<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Classes_PssWithoutClass extends Analyzer {
    /* 11 methods */

    public function testClasses_PssWithoutClass01()  { $this->generic_test('Classes_PssWithoutClass.01'); }
    public function testClasses_PssWithoutClass02()  { $this->generic_test('Classes_PssWithoutClass.02'); }
    public function testClasses_PssWithoutClass03()  { $this->generic_test('Classes_PssWithoutClass.03'); }
    public function testClasses_PssWithoutClass04()  { $this->generic_test('Classes_PssWithoutClass.04'); }
    public function testClasses_PssWithoutClass05()  { $this->generic_test('Classes_PssWithoutClass.05'); }
    public function testClasses_PssWithoutClass06()  { $this->generic_test('Classes_PssWithoutClass.06'); }
    public function testClasses_PssWithoutClass07()  { $this->generic_test('Classes_PssWithoutClass.07'); }
    public function testClasses_PssWithoutClass08()  { $this->generic_test('Classes_PssWithoutClass.08'); }
    public function testClasses_PssWithoutClass09()  { $this->generic_test('Classes_PssWithoutClass.09'); }
    public function testClasses_PssWithoutClass10()  { $this->generic_test('Classes_PssWithoutClass.10'); }
    public function testClasses_PssWithoutClass11()  { $this->generic_test('Classes_PssWithoutClass.11'); }
}
?>