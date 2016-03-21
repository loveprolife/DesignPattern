创建型设计模式包括简单工厂模式，普通工厂模式，抽象工厂模式，建造者模式，原型模式和最简单的单例模式。

简单工厂模式(Simple Factory)：

![image](https://github.com/loveprolife/IMG/blob/master/0.png)

<?php

abstract class Product
{
	abstract public function Operation();
}

class ConcreteProduct1 extends Product
{
	public function Operation()
	{
		return __METHOD__ ;
	}
}

class ConcreteProduct2 extends Product
{
	public function Operation()
	{
		return __METHOD__ ;
	}
}

class ConcreteProduct3 extends Product
{
	public function Operation()
	{
		return __METHOD__ ;
	}
}

class ConcreteProduct4 extends Product
{
	public function Operation()
	{
		return __METHOD__ ;
	}
}

class Factory
{
	public static function createObj($className)
	{
		$class = new ReflectionClass($className);
		return $class->newInstance();
	}
}

echo Factory::createObj('ConcreteProduct1')->Operation();

echo Factory::createObj('ConcreteProduct2')->Operation();

echo Factory::createObj('ConcreteProduct3')->Operation();

echo Factory::createObj('ConcreteProduct4')->Operation();

?>



(普通)工厂模式(Factory)：

![image](https://github.com/loveprolife/IMG/blob/master/1.png)

<?php


abstract class Product
{
	abstract function Operation();
}

class ConcreteProduct1
{
	public function Operation () 
	{
		return __METHOD__;
	}
}

class ConcreteProduct2
{
	public function Operation () 
	{
		return __METHOD__;
	}
}

abstract class Factory
{
	abstract function CreateProduct();
}


class ConcreteFactory1
{
	public static function CreteProduct () 
	{
		return new ConcreteProduct1();
	}
}


class ConcreteFactory2
{
	public static function CreteProduct () 
	{
		return new ConcreteProduct2();
	}
}


$product1 = ConcreteFactory1::CreteProduct();
echo $product1->Operation();

echo "</br>";

$product2 = ConcreteFactory2::CreteProduct();
echo $product2->Operation();



?>






抽象工厂模式（Abstract Factory）

![image](https://github.com/loveprolife/IMG/blob/master/2.png)

<?php


abstract class ProductA
{
	abstract function Operation();
}

class ProductA1
{
	public function Operation () 
	{
		return __METHOD__;
	}
}

class ProductA2
{
	public function Operation () 
	{
		return __METHOD__;
	}
}


abstract class ProductB
{
	abstract function Operation();
}

class ProductB1
{
	public function Operation () 
	{
		return __METHOD__;
	}
}

class ProductB2
{
	public function Operation () 
	{
		return __METHOD__;
	}
}


abstract class Factory
{
	abstract function CreateProductA();
	abstract function CreateProductB();
}


class ConcreteFactory1
{
	public static function CreteProductA () 
	{
		return new ProductA1();
	}

	public static function CreteProductB () 
	{
		return new ProductB1();
	}
}


class ConcreteFactory2
{
	public static function CreteProductA () 
	{
		return new ProductA2();
	}

	public static function CreteProductB () 
	{
		return new ProductB2();
	}
}


$a1 = ConcreteFactory1::CreteProductA();
echo $a1->Operation();

echo "</br>";

$b1 = ConcreteFactory1::CreteProductB();
echo $b1->Operation();

echo "</br>";

$a2 = ConcreteFactory2::CreteProductA();
echo $a2->Operation();

echo "</br>";

$b2 = ConcreteFactory2::CreteProductB();
echo $b2->Operation();

echo "</br>";

?>






建造者模式（Builder）

![image](https://github.com/loveprolife/IMG/blob/master/3.png)

<?php


class Bird
{
	public $_head;
	public $_wing;
	public $_foot;
	public function show ()
	{
		echo "头的颜色：{$this->_head}<br/>";
		echo "翅膀的颜色：{$this->_wing}<br/>";
		echo "脚的颜色：{$this->_foot}<br/>";
	}
}

abstract class BirdBuilder
{
	protected $_bird;

	public function __construct ()
	{
		$this->_bird = new Bird();
	}

	abstract function BuildHead();
	abstract function BuildWing();
	abstract function BuildFoot();
	abstract function GetBird();
}

class BlueBird extends BirdBuilder
{
	public function BuildHead () 
	{
		$this->_bird->_head = 'Blue';
	}
	
	public function BuildWing () 
	{
		$this->_bird->_wing = 'Blue';
	}

	public function BuildFoot () 
	{
		$this->_bird->_foot = 'Blue';
	}

	public function GetBird () 
	{
		return $this->_bird;
	}
}

class RoseBird extends BirdBuilder
{
	public function BuildHead () 
	{
		$this->_bird->_head = 'Rose';
	}
	
	public function BuildWing () 
	{
		$this->_bird->_wing = 'Rose';
	}

	public function BuildFoot () 
	{
		$this->_bird->_foot = 'Rose';
	}

	public function GetBird () 
	{
		return $this->_bird;
	}
}

class Director
{
	public function Construct ($_builder)
	{
		$_builder->BuildHead();
		$_builder->BuildWing();
		$_builder->BuildFoot();
		return $_builder->GetBird();
	}
}


$director = new Director();

$blue_bird = $director->Construct(new BlueBird);
$blue_bird->show();

$rose_bird = $director->Construct(new RoseBird);
$rose_bird->show();



?>




原型模式（Prototype）

![image](https://github.com/loveprolife/IMG/blob/master/yuanxingmoshi.jpg)

<?php

interface Prototype {
	public function shallow_copy();
	public function deep_copy();
}

class ConcretePrototype1 implements Prototype{
	private $name;
	private $obj;
	
	public function __construct ($name, $obj) {
		$this->name = $name;
		$this->obj = $obj;
	}
	
	public function getName () {
		return $this->name;
	}

	public function getObj () {
		return $this->obj;
	}

	public function setName ($name) {
		$this->name = $name;
	}

	public function setObj ($obj) {
		$this->obj = $obj;
	}

	/**
	 * 浅拷贝
	 */
	public function shallow_copy () {
		return clone $this;
	}

	/**
	 * 深拷贝
	 */
	public function deep_copy () {
		 return unserialize(serialize($this));
	}
}

/**
 * 测试深拷贝
 */
class Test {
	public $array;
}

class Client {
	public static function main () {

		 $test = new Test();
		 $test->array = array('0', '1', '2');

		 $pro1 = new ConcretePrototype1('test_name_1', $test);
		 $pro2 = $pro1->shallow_copy();
		 $pro3 = $pro1->deep_copy();

 		 $pro1->setName('test_name_2');
		 $test->array = array('a', 'b', 'c');
		 $pro1->setObj($test);

		 echo '<pre>';
		 print_r($pro1);
		 print_r($pro2);
		 print_r($pro3);
		 echo '</pre>';
	}
}

Client::main();

?>



单例模式（Singleton）

![image](https://github.com/loveprolife/IMG/blob/master/5.png)

<?php


class singleton {
	private static $_instance;

	private function __construct () {
		echo 'can not new';
	}

	private function __clone() {
		echo 'can not clone';
	}

	public static function getInstance () {
		if (!(self::$_instance instanceof self)) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function test () {
		echo 'success';
	}
}

//new实例化private的构造函数报错
//$single = new singleton();	//Fatal error: Call to private singleton::__construct() from invalid context in D:\WWW\test.php on line 28

//正确获取实例的方法
$single = singleton::getInstance();
$single->test();

//克隆对象报错
$single_test = clone $single;	//Fatal error: Call to private singleton::__clone() from context '' in D:\WWW\test.php on line 35

?>








