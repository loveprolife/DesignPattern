1.适配器模式

![image](https://github.com/loveprolife/IMG/blob/master/shipeiqi.gif)

<?php

interface Target {
	public function sampleMethod1 ();
	public function sampleMethod2 ();
}

class Adaptee {
	public function sampleMethod1 () {
		echo 'Adaper sampleMethod1<br/>';
	}
}

class Apapter implements Target {
	private $_adaptee = NULL;

	public function __construct (Adaptee $adaptee) {
		$this->_adaptee = $adaptee;
	}

	public function sampleMethod1 () {
		$this->_adaptee->sampleMethod1();
	}

	public function sampleMethod2 () {
		echo 'Adaper sampleMethod2<br/>';
	}
}

class Client {
	public static function main () {
		$adaptee = new Adaptee();
		
		$adapter = new Apapter($adaptee);
		$adapter->sampleMethod1();
		$adapter->sampleMethod2();
	}
}

Client::main();
?>





桥接模式

合成模式

装饰器模式

门面模式

代理模式

享元模式
