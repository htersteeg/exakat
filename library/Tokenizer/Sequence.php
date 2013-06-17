<?php

namespace Tokenizer;

class Sequence extends TokenAuto {
    function _check() {
        $operands = array('Addition', 'Multiplication', 'Sequence', 'String', 'Integer', 'Float', 'Not', 'Variable','_Array','Concatenation', 'Sign',
                          'Functioncall', );
        
        
        // @note instructions separated by ; 
        $this->conditions = array(-1 => array('atom' => $operands ),
                                   0 => array('code' => ';',
                                             'atom' => 'none'),
                                   1 => array('atom' => $operands),
        );
        
        $this->actions = array('makeEdge'    => array( 1 => 'ELEMENT',
                                                      -1 => 'ELEMENT'
                                                      ),
                               'order'    => array('1'  => '2',
                                                   '-1' => '1'
                                                      ),
                               'mergeNext'  => array('Sequence', 'ELEMENT'), 
                               'atom'       => 'Sequence',
                               );
        $r = $this->checkAuto();

        // @note End of PHP script
        $this->conditions = array(-1 => array('atom' => $operands ),
                                   0 => array('code' => ';',
                                             'atom' => 'none'),
                                   1 => array('token' => 'T_CLOSE_TAG',
                                              'atom'  => 'none'),
        );
        
        $this->actions = array('makeEdge'    => array(-1 => 'ELEMENT'
                                                      ),
                               'order'    => array('-1' => '1'),
                               'atom'       => 'Sequence',
                               );

        $r = $this->checkAuto();
        
        return $r;
    }
}
?>