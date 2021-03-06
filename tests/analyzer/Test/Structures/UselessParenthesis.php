<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Structures_UselessParenthesis extends Analyzer {
    /* 6 methods */

    public function testStructures_UselessParenthesis01()  { $this->generic_test('Structures_UselessParenthesis.01'); }
    public function testStructures_UselessParenthesis02()  { $this->generic_test('Structures_UselessParenthesis.02'); }
    public function testStructures_UselessParenthesis03()  { $this->generic_test('Structures_UselessParenthesis.03'); }
    public function testStructures_UselessParenthesis04()  { $this->generic_test('Structures_UselessParenthesis.04'); }
    public function testStructures_UselessParenthesis05()  { $this->generic_test('Structures/UselessParenthesis.05'); }
    public function testStructures_UselessParenthesis06()  { $this->generic_test('Structures/UselessParenthesis.06'); }
}
?>