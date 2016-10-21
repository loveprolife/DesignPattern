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

![image](https://github.com/loveprolife/IMG/blob/master/observer.jpg)

<?php

//抽象迭代器
abstract class IIterator{
    public abstract function First();
    public abstract function Next();
    public abstract function IsDone();
    public abstract function CurrentItem();
}

//具体迭代器
class ConcreteIterator extends IIterator{

    private $aggre;
    private $current = 0;

    public function __construct(array $_aggre){
        $this->aggre = $_aggre;
    }

    //返回第一个
    public function First(){
        return $this->aggre[0];
    }

    //返回下一个
    public function  Next(){
        $this->current++;
        if($this->current<count($this->aggre)) {
            return $this->aggre[$this->current];
        }
        return false;
    }

    //返回是否IsDone
    public function IsDone(){
        return ($this->current >= count($this->aggre)) ? true : false;
    }

    //返回当前聚集对象
    public function CurrentItem(){
        return $this->aggre[$this->current];
    }
}

$iterator= new ConcreteIterator(array('周杰伦','王菲','周润发'));
$item = $iterator->First();
echo $item."<br/>";
while(!$iterator->IsDone()){
    echo "{$iterator->CurrentItem()}：请买票！<br/>";
    $iterator->Next();
}

?>

5.责任链模式

![image](https://github.com/loveprolife/IMG/blob/master/chain.png)

<?php

//申请Model
class Request{

    //数量
    public $num;

    //申请类型
    public $requestType;

    //申请内容
    public $requestContent;
}

//抽象管理者
abstract class Manager{

    protected $name;

    //管理者上级
    protected $manager;

    public function __construct($_name){
        $this->name = $_name;
    }

    //设置管理者上级
    public function SetHeader(Manager $_mana){
        $this->manager = $_mana;
    }

    //申请请求
    abstract public function Apply(Request $_req);
}

//经理
class CommonManager extends Manager{

    public function __construct($_name){
        parent::__construct($_name);
    }

    public function Apply(Request $_req){
        if($_req->requestType == "请假" && $_req->num <= 2) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        } else {
            if(isset($this->manager)){
                $this->manager->Apply($_req);
            }
        }
    }
}

//总监
class MajorDomo extends Manager {

    public function __construct($_name){
        parent::__construct($_name);
    }

    public function Apply(Request $_req){
        if ($_req->requestType == "请假" && $_req->num <= 5) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        } else {
            if (isset($this->manager)) {
                $this->manager->Apply($_req);
            }
        }
    }
}

//总经理
class GeneralManager extends Manager{

    public function __construct($_name){
        parent::__construct($_name);
    }

    public function Apply(Request $_req){
        if ($_req->requestType == "请假") {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        } else if($_req->requestType=="加薪" && $_req->num <= 500) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}被批准。<br/>";
        } else if ($_req->requestType=="加薪" && $_req->num>500) {
            echo "{$this->name}:{$_req->requestContent} 数量{$_req->num}再说吧。<br/>";
        }
    }
}

//调用客户端代码：
$jingli = new CommonManager("李经理");
$zongjian = new MajorDomo("郭总监");
$zongjingli = new GeneralManager("孙总");

//设置直接上级
$jingli->SetHeader($zongjian);
$zongjian->SetHeader($zongjingli);

//申请
$req1 = new Request();
$req1->requestType = "请假";
$req1->requestContent = "小菜请假！";
$req1->num = 1;
$jingli->Apply($req1);

$req2 = new Request();
$req2->requestType = "请假";
$req2->requestContent = "小菜请假！";
$req2->num = 4;
$jingli->Apply($req2);

$req3 = new Request();
$req3->requestType = "加薪";
$req3->requestContent = "小菜请求加薪！";
$req3->num = 500;
$jingli->Apply($req3);

$req4 = new Request();
$req4->requestType = "加薪";
$req4->requestContent = "小菜请求加薪！";
$req4->num = 1000;
$jingli->Apply($req4);

?>

6.命令模式

![image](https://github.com/loveprolife/IMG/blob/master/commond.png)

<?php

/**命令接收者
 * Class Tv
 */
class Tv {

    public $curr_channel = 0;

    /**
     * 打开电视机
     */
    public function turnOn () {
        echo "The television is on." . "<br/>";
    }

    /**
     * 关闭电视机
     */
    public function turnOff () {
        echo "The television is off." . "<br/>";
    }

    /**切换频道
     * @param $channel
     */
    public function turnChannel ($channel) {
        $this->curr_channel = $channel;
        echo "This TV Channel is " . $this->curr_channel . "<br/>";
    }
}

/**执行命令接口
 * Interface ICommand
 */
interface ICommand {
    function execute();
}

/**开机命令
 * Class CommandOn
 */
class CommandOn implements ICommand {

    private $tv;

    public function __construct ($tv) {
        $this->tv = $tv;
    }

    public function execute () {
        $this->tv->turnOn();
    }
}

/**关机命令
 * Class CommandOn
 */
class CommandOff implements  ICommand {

    private $tv;

    public function __construct ($tv) {
        $this->tv = $tv;
    }

    public function execute () {
        $this->tv->turnOff();
    }
}

/**切换频道命令
 * Class CommandOn
 */
class CommandChannel implements ICommand {

    private $tv;
    private $channel;

    public function __construct ($tv, $channel) {

        $this->tv = $tv;
        $this->channel = $channel;
    }

    public function execute () {
        $this->tv->turnChannel($this->channel);
    }
}

/**遥控器
 * Class Control
 */
class Control {

    private $_onCommand;
    private $_offCommand;
    private $_changeChannel;

    public function __construct ($on, $off, $channel) {
        $this->_onCommand = $on;
        $this->_offCommand = $off;
        $this->_changeChannel = $channel;
    }

    public function turnOn () {
        $this->_onCommand->execute();
    }

    public function  turnOff () {
        $this->_offCommand->execute();
    }

    public function changeChannel () {
        $this->_changeChannel->execute();
    }
}

// 命令接收者 　
$myTv = new Tv();
// 开机命令 　
$on = new CommandOn($myTv);
// 关机命令 　
$off = new CommandOff($myTv);
// 频道切换命令 　
$channel = new CommandChannel($myTv, 2);
// 命令控制对象　
$control = new Control($on, $off, $channel);
// 开机 　
$control->turnOn();
// 切换频道 　
$control->changeChannel();
// 关机
$control->turnOff();

?>

7.备忘录模式

8.状态模式

9.访问者模式

10.中介者模式

11.解释器模式
