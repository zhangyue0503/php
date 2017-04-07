<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Container\Container;

/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/7
 * Time: 下午9:59
 *
 * --
-- Database: `lara`
--

-- --------------------------------------------------------

--
-- 表的结构 `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE `students` (
`id` int(11) NOT NULL,
`name` varchar(30) NOT NULL,
`age` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `students`
--

INSERT INTO `students` (`id`, `name`, `age`) VALUES
(1, 'wshuo', 21);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `students`
--
ALTER TABLE `students`
ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `students`
--
ALTER TABLE `students`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;COMMIT;
 *
 *
 *
 */
class WelcomeController
{
	public function index()
	{
//		return '<h1>控制器成功！</h1>';
		$student = Student::first();
		$data    = $student->getAttributes();
//		return "学生 id=" . $data['id'] . "； 学生 name=" . $data['name'] . "； 学生 age=" . $data['age'];
		$app = Container::getInstance();
		$factory = $app->make('view');
		return $factory->make('welcome')->with('data',$data);

	}


}