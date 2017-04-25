<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbRecords extends Model
{
	protected $table = 'tb_records';
	public $timestamps = false;
	protected $fillable = ['title', 'content', 'cid', 'uid', 'addtime', 'state'];
	protected $guarded = ['id'];
	static $state = ['use' => 1, 'delete' => 0];

	public function insert($param)
	{
		if (isset($param['uid']) && $param['uid'] > 0) {
			$tbmodel      = new TbCategory();
			$param['cid'] = isset($param['cid']) ? $param['cid'] : $tbmodel->firstOrNewId($param['id']);
			$this->fill($param);
			$suc = $this->save();
			if ($suc) {
				$cat        = TbCategory::find($param['cid']);
				$cat->count = $cat->count + 1;
				return $cat->save();
			}
		}
		return false;
	}

	public function findUserAll($uid, $cid = 0)
	{
		$st = self::$state['use'];
		if ($cid > 0) {
			$recordsList = static::whereRaw("uid={$uid} and cid={$cid} and state={$st}")->get()->toArray();
		} else {
			$recordsList = static::whereRaw("uid={$uid} and state={$st}")->get()->toArray();
		}
		return $recordsList;
	}

	public function changeCat($uid, $cid, $nextId)
	{
		$st = self::$state['use'];
		return static::whereRaw("uid={$uid} and cid={$cid} and state={$st}")->update(['cid' => $nextId]);
	}
}
