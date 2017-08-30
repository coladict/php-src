--TEST--
SCCP 008: Conditional Constant Propagation of non-escaping array elements
--INI--
opcache.enable=1
opcache.enable_cli=1
opcache.optimization_level=-1
opcache.opt_debug_level=0x20000
--SKIPIF--
<?php require_once('skipif.inc'); ?>
--FILE--
<?php
function foo(int $x) {
	if ($x) {
		$a = [0,1];
	} else {
		$a = [0,2];
	}
	echo $a[1];
}
?>
--EXPECTF--
$_main: ; (lines=1, args=0, vars=0, tmps=0)
    ; (after optimizer)
    ; /home/dmitry/php/php-master/ext/opcache/tests/opt/sccp_008.php:1-11
L0:     RETURN int(1)

foo: ; (lines=8, args=1, vars=2, tmps=1)
    ; (after optimizer)
    ; /home/dmitry/php/php-master/ext/opcache/tests/opt/sccp_008.php:2-9
L0:     CV0($x) = RECV 1
L1:     JMPZ CV0($x) L4
L2:     CV1($a) = QM_ASSIGN array(...)
L3:     JMP L5
L4:     CV1($a) = QM_ASSIGN array(...)
L5:     V2 = FETCH_DIM_R CV1($a) int(1)
L6:     ECHO V2
L7:     RETURN null
