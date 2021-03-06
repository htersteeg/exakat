<?php

namespace Test;

include_once(dirname(dirname(dirname(dirname(__DIR__)))).'/library/Autoload.php');
spl_autoload_register('Autoload::autoload_test');
spl_autoload_register('Autoload::autoload_phpunit');
spl_autoload_register('Autoload::autoload_library');

class Structures_EmptyBlocks extends Analyzer {
    /* 9 methods */

    public function testStructures_EmptyBlocks01()  { $this->generic_test('Structures/EmptyBlocks.01'); }
    public function testStructures_EmptyBlocks02()  { $this->generic_test('Structures/EmptyBlocks.02'); }
    public function testStructures_EmptyBlocks03()  { $this->generic_test('Structures/EmptyBlocks.03'); }
    public function testStructures_EmptyBlocks04()  { $this->generic_test('Structures/EmptyBlocks.04'); }
    public function testStructures_EmptyBlocks05()  { $this->generic_test('Structures/EmptyBlocks.05'); }
    public function testStructures_EmptyBlocks06()  { $this->generic_test('Structures/EmptyBlocks.06'); }
    public function testStructures_EmptyBlocks07()  { $this->generic_test('Structures/EmptyBlocks.07'); }
    public function testStructures_EmptyBlocks08()  { $this->generic_test('Structures/EmptyBlocks.08'); }
    public function testStructures_EmptyBlocks09()  { $this->generic_test('Structures/EmptyBlocks.09'); }
}
?>