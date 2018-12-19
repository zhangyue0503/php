<?php 
class MicrowaveOven {

	// 是否加热中
	private $isHeating = false;
	// 是否开门
	private $open = false;
	// 温度
	private $temperature = 0;
	// 时间
	private $time = 0; // 秒
	// 物品
	private $food = '';
	// 带皮食物
	private $peelFood = ['苹果', '香蕉'];
	// 带壳食物
	private $shellFood = ['虾', '核桃'];

	// 设定时间
	public function setTime($t){
		$this->time = intval($t);
	}
	// 设定温度
	public function setTemperature($t){
		$this->temperature = intval($t);
	}
	// 开始
	public function start() {
		if($this->open){
			print_r('门还开着呢!');
			return;
		}
		if($this->time == 0 || $this->temperature == 0){
			print_r('请选择时间及温度');
			return;
		}
		if(!$this->food){
			print_r('没有放入食物');
			return;
		}
		$this->heating();
	}
	// 停止
	public function stop(){
		$this->isHeating = false;
	}
	// 开门
	public function open(){
		if($this->isHeating){
			print_r('食品正在加热，不能开门');
			return;
		}
		$this->open = true;
	}
	// 关门
	public function close(){
		if(!$this->open){
			print_r('门已经关了');
			return;
		}
		$this->open = false;
	}
	// 放入
	public function in($f){
		if(!$this->open){
			print_r('还没有开门!');
		}
		if(in_array($f, $this->peelFood)){
			print_r('不能加热带皮食物');
			return ;
		}
		if(in_array($f, $this->shellFood)){
			print_r('不能加热带壳食物');
			return;
		}
		$this->food = $f;
	}
	// 取出
	public function out(){
		print_r('取出加热完成的食物：' . $this->food);
	}
	// 加热
	public function heating(){
		$this->isHeating = true;
		// 计时
		$startTime = time();
		$endTime = time() + $this->time;
		if(time() > $endTime){
			// 退出
			$this->stop();
		}
	}
}

$test = new MicrowaveOven();
// $test->start();

$test->open();
$test->in('汉堡');
$test->setTime(10);
$test->setTemperature(200);
// $test->start();
$test->close();
$test->start();
$test->open();
sleep(10);
$test->open();
$test->out();

