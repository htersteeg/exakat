<?php
      $a{$b{"c"}}{"d"} = 1;
      $a{$b{"c"}}{"d" + 2} = 1;
      $a{$b{"c"}}{"d" + 2 * $e ? 5 : 6} = 1;
?>