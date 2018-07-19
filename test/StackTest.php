<?php
require_once '../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class StackTest extends TestCase {
	
	public function testPushAndPop() {
		$stack = [];
		array_push($stack, 'foo');
		$this->assertSame('foo', $stack[0]);
	}
}	
