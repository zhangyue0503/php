<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/11
 * Time: 下午9:32
 */
//设计公共接口
interface Visit{
	public function go();
}
//实现不同交通工具类
class Leg implements Visit {
	public function go()
	{
		echo "walt to Tibet!!";
	}
}
class Car implements Visit {
	public function go()
	{
		echo "drive car to Tibet!!";
	}
}
class Train implements Visit {
	public function go()
	{
		echo "go to Tibet by train!!";
	}
}
//设计简单工厂，对于不同的输入，实例化不同的交通工具
class TrafficToolFactory{
	public function createTrafficTool($name){
		switch ($name){
			case 'Leg':
				return new Leg();
				break;
			case 'Car':
				return new Car();
				break;
			case 'Train':
				return new Train();
				break;
			default:
				exit('set trafficTool error!!');
				break;
		}
	}
}
//设计旅游者类，该类在实现游西藏的功能时要依赖交通工具实例
class Traveller{
	protected $trafficTool;
	public function __construct($trafficTool)
	{
		//通过工厂产生依赖的交通工具
		$factory = new TrafficToolFactory();
		$this->trafficTool = $factory->createTrafficTool($trafficTool);
	}
	public function visitTibet(){
		$this->trafficTool->go();
	}
}

$tra = new Traveller('Train');
$tra->visitTibet();