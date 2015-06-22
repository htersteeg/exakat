<?php

namespace Test;

include_once(dirname(dirname(dirname(__DIR__))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Classes_DynamicClass extends Analyzer {
    /* 1 methods */

    public function testClasses_DynamicClass01()  { $this->generic_test('Classes_DynamicClass.01'); }
}
?>