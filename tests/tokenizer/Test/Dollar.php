<?php

namespace Test;

include_once(dirname(dirname(dirname(__DIR__))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');

class Dollar extends Tokenizer {
    /* 1 methods */

    public function testDollar01()  { $this->generic_test('Dollar.01'); }
}
?>