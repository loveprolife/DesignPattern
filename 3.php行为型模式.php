1.策略模式

![image](https://github.com/loveprolife/IMG/blob/master/celue.png)

<?php  

/**抽象策略角色 
 * Interface RotateItem 
 */  
interface RotateItem  
{  
    function inertiaRotate();  
    function unInertisRotate();  
}  
  
/**具体策略角色——X产品 
 * Class XItem 
 */  
class XItem implements RotateItem  
{  
    function inertiaRotate()  
    {  
        echo "我是X产品，我惯性旋转了。<br/>";  
    }  
  
    function unInertisRotate()  
    {  
        echo "我是X产品，我非惯性旋转了。<br/>";  
    }  
}  
  
/**具体策略角色——Y产品 
 * Class YItem 
 */  
class YItem implements RotateItem  
{  
    function inertiaRotate()  
    {  
        echo "我是Y产品，我<span style='color: #ff0000;'>不能</span>惯性旋转。<br/>";  
    }  
  
    function unInertisRotate()  
    {  
        echo "我是Y产品，我非惯性旋转了。<br/>";  
    }  
}  
  
/**具体策略角色——XY产品 
 * Class XYItem 
 */  
class XYItem implements RotateItem  
{  
    function inertiaRotate()  
    {  
        echo "我是XY产品，我惯性旋转。<br/>";  
    }  
  
    function unInertisRotate()  
    {  
        echo "我是XY产品，我非惯性旋转了。<br/>";  
    }  
}  
  
class contextStrategy  
{  
    private $item;  
  
    function getItem($item_name)  
    {  
        try  
        {  
            $class=new ReflectionClass($item_name);  
            $this->item=$class->newInstance();  
        }  
        catch(ReflectionException $e)  
        {  
            $this->item="";  
        }  
    }  
  
    function inertiaRotate()  
    {  
        $this->item->inertiaRotate();  
    }  
  
    function unInertisRotate()  
    {  
        $this->item->unInertisRotate();  
    }  
}

header("Content-Type:text/html;charset=utf-8");  

$strategy=new contextStrategy();  
  
echo "<span style='color: #ff0000;'>X产品</span><hr/>";  
$strategy->getItem('XItem');  
$strategy->inertiaRotate();  
$strategy->unInertisRotate();  
  
echo "<span style='color: #ff0000;'>Y产品</span><hr/>";  
$strategy->getItem('YItem');  
$strategy->inertiaRotate();  
$strategy->unInertisRotate();  
  
echo "<span style='color: #ff0000;'>XY产品</span><hr/>";  
$strategy->getItem('XYItem');  
$strategy->inertiaRotate();  
$strategy->unInertisRotate();  
?>

2.模板方法模式

![image](https://github.com/loveprolife/IMG/blob/master/mubanfangfa.png)

<?php  

//抽象模板类  
abstract class MakePhone  
{  
    protected $name;  
  
    public function __construct($name)  
    {  
        $this->name=$name;  
    }  
  
    public function MakeFlow()  
    {  
        $this->MakeBattery();  
        $this->MakeCamera();  
        $this->MakeScreen();  
        echo $this->name."手机生产完毕！<hr/>";  
    }  
    public abstract function MakeScreen();  
    public abstract function MakeBattery();  
    public abstract function MakeCamera();  
}  
  
//小米手机  
class XiaoMi extends MakePhone  
{  
    public function __construct($name='小米')  
    {  
        parent::__construct($name);  
    }  
  
    public   function MakeBattery()  
    {  
        echo "小米电池生产完毕！<br/>";  
    }  
    public   function MakeCamera()  
    {  
        echo "小米相机生产完毕！<br/>";  
    }  
  
    public  function MakeScreen()  
    {  
        echo "小米屏幕生产完毕！<br/>";  
    }  
}  
  
//魅族手机  
class FlyMe  extends  MakePhone  
{  
    function __construct($name='魅族')  
    {  
        parent::__construct($name);  
    }  
  
    public   function MakeBattery()  
    {  
        echo "魅族电池生产完毕！<br/>";  
    }  
    public   function MakeCamera()  
    {  
        echo "魅族相机生产完毕！<br/>";  
    }  
  
    public   function MakeScreen()  
    {  
        echo "魅族屏幕生产完毕！<br/>";  
    }  
}  

header("Content-Type:text/html;charset=utf-8");  

$miui=new XiaoMi();  
$flyMe=new FlyMe();  
  
$miui->MakeFlow();  
$flyMe->MakeFlow();  

?>

3.观察者模式(观察者模式又叫做发布-订阅（Publish/Subscribe）模式、模型-视图（Model/View）模式、源-监听器（Source/Listener）模式或从属者（Dependents）模式)

![image](https://github.com/loveprolife/IMG/blob/master/observer.jpg)

<?php
header("Content-type:text/html;Charset=utf-8");
//目标接口，定义观察目标要实现的方法
abstract class Subject{
   abstract function attach(Observer $observer);  //添加观察者
   abstract function detach(Observer $observer);  //去除观察者
   abstract function notify();  //满足条件时通知所有观察者修改
   abstract function condition($num); //发起通知的条件
}
//具体观察目标
class ConcreteSubject extends Subject{
    private $observers = array();
    //添加观察者
    function attach(Observer $observer){
         $this->observers[] = $observer;
    }
    //移除观察者
    function detach(Observer $observer){
         $key=array_search($observer, $this->observers);
         if($key !== false){  //注意不要写成!=,表达式0!=flase为flase
              unset($this->observers[$key]);
         }
    }
    //通知所有所有观察者修改
    function notify(){
        foreach($this->observers as $observer){
            $observer->update();
        }
    }
    //发起通知的条件
    function condition($num){
        if($num>100){
            $this->notify();
        }
    }
}

//抽象观察者接口，定义所有观察者共同具有的属性——执行修改
abstract class Observer{
    abstract function update();
}
//具体观察者类，实现抽象观察者接口
class ConcreteObserverA extends Observer{

    function update(){
       echo "A报告:敌军超过一百人了，快撤！<br>";
    }
    //其他函数
    function eat(){
        echo "A在吃饭";
    }
}
class ConcreteObserverB extends Observer{

    function update(){
       echo "B报告:敌军超过一百人了，快撤！<br>";
    }
    //其他函数
    function sleep(){
        echo "B在睡觉";
    }
}


//测试
$observerA = new ConcreteObserverA();
$observerB = new ConcreteObserverB();
$concreteSubject = new ConcreteSubject();
$concreteSubject->attach($observerA);  //添加观察者A
$concreteSubject->detach($observerA);  //去除观察者A
$concreteSubject->attach($observerA);
$concreteSubject->attach($observerB);
$concreteSubject->condition(1000);

 ?>

4.迭代器模式

5.责任链模式

6.命令模式

7.备忘录模式

8.状态模式

9.访问者模式

10.中介者模式

11.解释器模式
