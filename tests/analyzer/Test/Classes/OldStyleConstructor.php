<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Classes_OldStyleConstructor extends Analyzer {
    /* 4 methods */

    public function testClasses_OldStyleConstructor01()  { $this->generic_test('Classes_OldStyleConstructor.01'); }
    public function testClasses_OldStyleConstructor02()  { $this->generic_test('Classes_OldStyleConstructor.02'); }
    public function testClasses_OldStyleConstructor03()  { $this->generic_test('Classes_OldStyleConstructor.03'); }
    public function testClasses_OldStyleConstructor04()  { $this->generic_test('Classes_OldStyleConstructor.04'); }
}
?>