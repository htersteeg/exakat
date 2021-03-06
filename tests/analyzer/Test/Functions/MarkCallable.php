<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Functions_MarkCallable extends Analyzer {
    /* 6 methods */

    public function testFunctions_MarkCallable01()  { $this->generic_test('Functions_MarkCallable.01'); }
    public function testFunctions_MarkCallable02()  { $this->generic_test('Functions_MarkCallable.02'); }
    public function testFunctions_MarkCallable03()  { $this->generic_test('Functions_MarkCallable.03'); }
    public function testFunctions_MarkCallable04()  { $this->generic_test('Functions_MarkCallable.04'); }
    public function testFunctions_MarkCallable05()  { $this->generic_test('Functions_MarkCallable.05'); }
    public function testFunctions_MarkCallable06()  { $this->generic_test('Functions/MarkCallable.06'); }
}
?>