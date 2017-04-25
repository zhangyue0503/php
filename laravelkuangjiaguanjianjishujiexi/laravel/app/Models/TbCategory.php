<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbCategory extends Model
{
	protected $table = 'tb_category';
	public $timestamps = false;
	protected $fileable = ['name', 'count', 'uid', 'state'];
	protected $guarded = ['id'];
	static $state = ['use' => 1, 'delete' => 0];

	public function findUserAll($uid = 0)
	{
		if ($uid != 0) {
			$st     = self::$state['use'];
			$catArr = static::whereRaw("uid={$uid} and state={$st}")->get()->toArray();
			return $catArr;
		} else {
			return null;
		}
	}

	public function firstOrNewId($uid)
	{
		$st      = self::$state['use'];
		$modColl = static::whereRaw("uid={$uid} and state={$st}")->get();
		if ($modColl->count() > 0) {
			$id = $modColl->first()->getAttribute('id');
			return $id;
		} else {
			return $this->createNewCat($uid);
		}
	}

	public function categoryAdd($param)
	{
		$param['name'] = isset($param['name']) ? $param['name'] : '思维笔记';
		if (empty($param['uid'])) {
			return;
		}
		$this->create([
			'name'  => $param['name'],
			'count' => 0,
			'uid'   => $param['uid'],
			'state' => self::$state['use']
		]);
	}

	public function deleteCat($uid, $cid)
	{
		$model        = $this->find($cid);
		$model->state = self::$state['delete'];
		$model->save();
		return $this->firstOrNewId($uid);
	}

	public function firstId($uid)
	{
		$st      = self::$state['use'];
		$modColl = static::whereRaw("uid={$uid} and state={$st}")->get();
		if ($modColl->count() > 0) {
			$id = $modColl->first()->getAttribute['id'];
			return $id;
		} else {
			return null;
		}
	}

	public function createNewCat($uid, $name = null)
	{
		$username = $name ? '思维笔记' : $name;
		$model    = $this->create([
			'name'  => $username,
			'count' => 0
		]);
		return $model['id'];
	}

	public function countReduce($cid, $num)
	{
		$model        = static::find($cid);
		$model->count = $model->count - $num;
		$model->save();
	}

}
