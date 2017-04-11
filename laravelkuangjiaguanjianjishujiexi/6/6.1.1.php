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
//设计旅游者类，该类在实现游西藏的功能时要依赖交通工具实例
class Traveller{
	protected $trafficTool;
	public function __construct()
	{
		//依赖产生
		$this->trafficTool = new Leg();
	}
	public function visitTibet(){
		$this->trafficTool->go();
	}
}

$tra = new Traveller();
$tra->visitTibet();