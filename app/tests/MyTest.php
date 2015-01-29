<?php

class MyTest extends TestCase {

	public function testIndex()
	{
		$this->call('GET', '/');
		$this->assertResponseOk();
		$this->assertViewHas('articles');
		$this->assertViewHas('tags');
	}
	
}