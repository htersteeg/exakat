<?php

$expected     = array('use a\b\ClassCaseNotOK as AliasCaseNotOK',
                      'new classcasenotok( )',
                      '$x instanceof aliascasenotok',
                      'aliascasenotok::x',
                      'aliascasenotok::$x',
                      'aliascasenotok::x( )',
                      'aliascasenotok $a',
                      'catch (aliascasenotok $e) { /**/ } ',
);

$expected_not = array(
);

?>