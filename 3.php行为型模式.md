1.策略模式

![image](https://github.com/loveprolife/IMG/blob/master/shipeiqi.gif)

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

3.观察者模式

4.迭代器模式

5.责任链模式

6.命令模式

7.备忘录模式

8.状态模式

9.访问者模式

10.中介者模式

11.解释器模式
