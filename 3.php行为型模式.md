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

3.观察者模式

4.迭代器模式

5.责任链模式

6.命令模式

7.备忘录模式

8.状态模式

9.访问者模式

10.中介者模式

11.解释器模式
