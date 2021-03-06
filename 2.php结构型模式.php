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

<?php

/**阿里股票
 * Class Ali
 */
class Ali{
    function buy(){
        echo "买入阿里股票<br/>";
    }

    function sell(){
        echo "卖出阿里股票<br/>";
    }
}

/**万达股票
 * Class Wanda
 */
class Wanda{
    function buy(){
        echo "买入万达股票<br/>";
    }

    function sell(){
        echo "卖出万达股票<br/>";
    }
}

/**京东股票
 * Class Jingdong
 */
class Jingdong{
    function buy(){
        echo "买入京东股票<br/>";
    }

    function sell(){
        echo "卖出京东股票<br/>";
    }
}

/**门面模式核心角色
 * Class FacadeCompany
 */
class FacadeCompany{
    private $ali;

    private $wanda;

    private $jingdong;

    function __construct(){
        $this->ali=new Ali();
        $this->jingdong=new Jingdong();
        $this->wanda=new Wanda();
    }

    function buy(){
        $this->wanda->buy();
        $this->ali->buy();
    }

    function sell(){
        $this->jingdong->sell();
    }
}

$lurenA = new FacadeCompany();
$lurenA->buy();
$lurenA->sell();

?>


6.代理模式

![image](https://github.com/loveprolife/IMG/blob/master/proxy.png)

<?php
//定义一种类型的女人，王婆和潘金莲都属于这个类型的女人 
interface KindWomen 
{  
  //这种类型的女人能做什么事情呢？ 
  public function makeEyesWithMan();//抛媚眼 
  public function happyWithMan();//happy what? You know that! 
}
 
//定一个潘金莲是什么样的人 
class PanJinLian implements KindWomen 
{
        public function happyWithMan() {                 
                echo "潘金莲在和男人做那个.....";
        }
        public function makeEyesWithMan() { 
                echo "潘金莲抛媚眼";
        } 
}

//王婆这个人老聪明了，她太老了，是个男人都看不上， 
//但是她有智慧有经验呀，她作为一类女人的代理！ 
class WangPo implements KindWomen { 
        var $kindWomen; 
  
        //她可以是KindWomen的任何一个女人的代理，只要你是这一类型
        public function WangPo($kindWomen = null){ 
                if (empty($kindWomen)) {
                        $this->kindWomen = new PanJinLian();//默认的话，是潘金莲的代理  
                }else{
                        $this->kindWomen = $kindWomen; 
                }
        } 
        //自己老了，干不了，可以让年轻的代替 
        public function happyWithMan() { 
                $this->kindWomen->happyWithMan();  
        }
         //王婆这么大年龄了，谁看她抛媚眼？！ 
        public function makeEyesWithMan() { 
                $this->kindWomen->makeEyesWithMan();  
        }  
}

//定义一个西门庆，这人色中饿鬼 
class XiMenQing 
{ 
  /* 
  * 水浒里是这样写的：西门庆被潘金莲用竹竿敲了一下难道，痴迷了， 
  * 被王婆看到了,  就开始撮合两人好事，王婆作为潘金莲的代理人 
  * 收了不少好处费，那我们假设一下： 
  * 如果没有王婆在中间牵线，这两个不要脸的能成吗？难说的很！ 
  */ 
  public function __construct() { 
        //把王婆叫出来 
        $wangPo = new WangPo();    
        //然后西门庆就说，我要和潘金莲happy，然后王婆就安排了西门庆丢筷子的那出戏: 
          $wangPo->makeEyesWithMan();  //看到没，虽然表面上时王婆在做，实际上爽的是潘金莲 
          $wangPo->happyWithMan(); 
  } 
}

//开搞了
$XiMengQing = new XiMenQing();
?>

7.享元模式


![image](https://github.com/loveprolife/IMG/blob/master/xiangyuan.png)

<?php  
/** 
 *  抽象享元角色 
 */  
abstract class Flyweight {  
    abstract public function operation( $state );  
}  
/** 
 * 具体享元角色 
 */  
class ConcreteFlyweight extends Flyweight {  
    private $_intrinsicState = null;  
    public function __construct( $state ) {  
        $this->_intrinsicState = $state;  
    }  
    public function operation( $state ) {  
        echo 'ConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState. ' Extrinsic State = ' . $state . "\n";  
    }  
}  
/** 
 * 不共享的具体享元，客户端直接调用 
 */  
class UnsharedConcreteFlyweight extends Flyweight {  
    private $_intrinsicState = null;  
    public function __construct( $state ) {  
        $this->_intrinsicState = $state;  
    }  
    public function operation( $state ) {  
        echo 'UnsharedConcreteFlyweight operation, Intrinsic State = ' . $this->_intrinsicState. ' Extrinsic State = ' . $state . "\n";  
    }  
}  
/** 
 * 享元工厂角色 
 */  
class FlyweightFactory {  
    private $_flyweights;  
    public function __construct() {  
        $this->_flyweights = array();  
    }  
    public function getFlyweigth( $state ) {  
        if ( isset( $this->_flyweights[$state] ) ) {  
            return $this->_flyweights[$state];  
        } else {  
            return $this->_flyweights[$state] = new ConcreteFlyweight( $state );  
        }  
    }  
}  
$flyweightFactory = new FlyweightFactory();  
$flyweight = $flyweightFactory->getFlyweigth( 'state A' );  
$flyweight->operation( 'other state A' );  
$flyweight = $flyweightFactory->getFlyweigth( 'state B' );  
$flyweight->operation( 'other state B' );  
/* 不共享的对象，单独调用 */  
$uflyweight = new UnsharedConcreteFlyweight( 'state A' );  
$uflyweight->operation( 'other state A' );  
  
?>  
运行结果：  
ConcreteFlyweight operation, Intrinsic State = state A Extrinsic State = other state A  
ConcreteFlyweight operation, Intrinsic State = state B Extrinsic State = other state B  
UnsharedConcreteFlyweight operation, Intrinsic State = state A Extrinsic State = other state A  
