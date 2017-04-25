<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Model;

class Users extends Model implements Authenticatable ,CanResetPassword
{
	use \Illuminate\Auth\Authenticatable,\Illuminate\Auth\Passwords\CanResetPassword;
	protected $table = 'users';
	public $timestamps = false;
	protected $fillable = ['username','account','password','addtime'];
	protected $guarded = ['id'];

	public function findAll(){
		$userList = $this->all();
		return $userList;
	}

}
