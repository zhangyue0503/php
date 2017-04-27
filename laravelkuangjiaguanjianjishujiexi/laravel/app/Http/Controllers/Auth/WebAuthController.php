<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/26
 * Time: 下午10:43
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Models\Users;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class WebAuthController extends Controller
{
	use AuthenticatesUsers, RegistersUsers;

	public function __construct()
	{
		$this->middleware('guest', ['except' => ['getLogout', 'getRegister']]);
	}

	protected function validator(array $data){
		return Validator::make($data,[
			'username'=>'required|max:255',
			'account'=>'required|max:255|unique:users',
			'password'=>'required|confirmed|min:6'
		]);
	}

	protected function create(array $data){
		return Users::create([
			'username'=>$data['username'],
			'account'=>$data['account'],
			'password'=>bcrypt($data['password']),
			'addtime'
		]);
	}
}