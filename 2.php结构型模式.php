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






2.桥接模式

![image](https://github.com/loveprolife/IMG/blob/master/qiaojiemoshi.png)

<?php

abstract class AbstractRoad {
	private $_icar;
	public function setIcar($icar){}
	public function Run(){}
}

class SpeedWay extends AbstractRoad {
	public function setIcar ($icar) {
		$this->_icar = $icar;
	}

	public function Run () {
		$this->_icar->icarFunction();
		echo ':在高速公路上。';
	}
}

class Street extends AbstractRoad {
	public function setIcar ($icar) {
		$this->_icar = $icar;
	}

	public function Run () {
		$this->_icar->icarFunction();
		echo ':在路上。';
	}
}

interface ICar {
	public function icarFunction();
}

class Jeep implements ICar {
	public function icarFunction () {
		echo '吉普车跑';
	}
}

class Bus implements ICar {
	public function icarFunction () {
		echo '公交车跑';
	}
}

class client {
	public static function main () {
		$speedWay = new SpeedWay();
		$speedWay->setIcar(new Jeep());
		$speedWay->Run();
		echo '<br/>';
		$speedWay->setIcar(new Bus());
		$speedWay->Run();

		echo '<hr/>';
		$street = new Street();
		$street->setIcar(new Jeep());
		$street->Run();
		echo '<br/>';
		$street->setIcar(new Bus());
		$street->Run();
	}
}

client::main();
?>





3.组合(组合)模式

![image](https://github.com/loveprolife/IMG/blob/master/composite.png)

<?php

abstract class Company {
	protected $name;

	protected function __construct ($name) {
		$this->name = $name;
	}

	abstract function Add (Company $company);

	abstract function Remove (Company $company);

	abstract function Display ($depth = 0);
}

class SubCompany extends Company {
	private $sub_companys = array();

	public function __construct ($name) {
		parent::__construct($name);
	}

	public function Add (Company $company) {
		$this->sub_companys[] = $company;
	}

	public function Remove (Company $company) {
		$key = array_search($company, $this->sub_companys);
		if ($key !== false) {
			unset($this->sub_companys[$key]);
		}
	}

	public function Display ($depth = 0) {
		$pre = '';
		for ($i=0; $i<$depth; $i++) {
			$pre .= '-';
		}
		$pre .= $this->name;
		echo $pre;
		echo '<br/>';

		foreach ($this->sub_companys as $v) {
			$v->Display($depth+2);
		}
	}
}

class MoneyDept extends Company {
	public function __construct ($name) {
		parent::__construct($name);
	}

	public function Add (Company $company) {
		echo '叶子节点，不能继续添加节点。';
	}

	public function Remove (Company $company) {
		echo '叶子节点，不能删除节点。';
	}

	public function Display ($depth = 0) {
		$pre = '';
		for ($i=0; $i<$depth; $i++) {
			$pre .= '-';
		}
		$pre .= $this->name;
		echo $pre;
		echo '<br/>';
	}
}

class TechnologyDept extends Company {
	public function __construct ($name) {
		parent::__construct($name);
	}

	public function Add (Company $company) {
		echo '叶子节点，不能继续添加节点。';
	}

	public function Remove (Company $company) {
		echo '叶子节点，不能删除节点。';
	}

	public function Display ($depth = 0) {
		$pre = '';
		for ($i=0; $i<$depth; $i++) {
			$pre .= '-';
		}
		$pre .= $this->name;
		echo $pre;
		echo '<br/>';
	}
}

class Client {
	public static function main () {
		$root = new SubCompany('北京总公司');
		$root->Add(new MoneyDept('北京总公司财务部'));
		$root->Add(new TechnologyDept('北京总公司技术部'));

		$shanghai = new SubCompany('上海分公司');
		$shanghai->Add(new MoneyDept('上海分公司财务部'));
		$shanghai->Add(new TechnologyDept('上海分公司技术部'));
		$root->Add($shanghai);

		$root->Display();
		
		$root->Remove($shanghai);

		$root->Display();
	}
}

Client::main();

?>


4.装饰器模式

![image](https://github.com/loveprolife/IMG/blob/master/decorator.jpg)

<?php
interface Component{
    public function operation();
}
 
abstract class Decorator implements Component{
    protected $component;
 
    public function __construct(Component $component){
        $this->component = $component;
    }
 
    public function operation(){
        $this->component->operation();
    }
}
 
class ConcreteComponent implements Component{
    public function operation(){
        echo 'ConcreteComponent<br/>';
    }
}

class ConcreteDecoratorA extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
 
    }
 
    public function operation() {
        parent::operation();
        $this->addedOperationA();
    }
 
    public function addedOperationA() {
        echo 'ConcreteDecoratorA addedOperationA<br/>';
    }
}
 
class ConcreteDecoratorB extends Decorator {
    public function __construct(Component $component) {
        parent::__construct($component);
 
    }
 
    public function operation() {
        parent::operation();
        $this->addedOperationB();
    }
 
    public function addedOperationB() {
        echo 'ConcreteDecoratorB addedOperationB<br/>';
    }
}

class Client {
    public static function main() {
		$component = new ConcreteComponent();

        $decoratorA = new ConcreteDecoratorA($component);
        $decoratorA->operation();
 
		echo '<hr/>';

        $decoratorB = new ConcreteDecoratorB($decoratorA);
        $decoratorB->operation();
    }
}

Client::main();
?>


5.门面模式(外观模式)

![image](https://github.com/loveprolife/IMG/blob/master/menmiaomoshi_waiguanmoshi.png)



6.代理模式

7.享元模式

