<?php
require_once __DIR__ . '/vendor/autoload.php';

$source = <<<EOF
print "lel";
foo <= 23;
// this is a comment
(( )){} // grouping stuff
!*+-/=<> <= == // operators
EOF;

$nyol = new Nyol\Nyol();
$nyol->run($source);
