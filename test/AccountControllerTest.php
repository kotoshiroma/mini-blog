<?php


use PHPUnit\Framework\TestCase;

class AccountControllerTest extends TestCase {
	
	public function testPushAndPop() {
		$stack = [];
		array_push($stack, 'foo');
		$this->assertSame('foo', $stack[0]);
	}
}	
