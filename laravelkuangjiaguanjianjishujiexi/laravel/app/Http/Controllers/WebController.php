<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/26
 * Time: 下午11:03
 */

namespace App\Http\Controllers;


use Illuminate\Contracts\Auth\Guard;

class WebController extends Controller
{
	private $attributes = [];

	public function __construct(Guard $auth)
	{
		$this->middleware('auth');
		$this->auth = $auth;
		if ($this->auth->user()) {
			$this->authSave();
		}

	}

	private function authSave()
	{
		$this->attributes['username'] = $this->auth->user()->getAttribute('username');
		$this->attributes['uid']      = $this->auth->id();
	}

	private function getAttribute($key)
	{
		return $this->attributes[$key];
	}

	private function addAttributes($param, $value)
	{
		$this->attributes[$param] = $value;
	}

	public function getIndex()
	{
		$user = $this->auth->user();
		return view('/backyard/index/index')->with('attributes', $this->attributes);
	}

	public function getUserList()
	{
		$model = new Users();
		$data  = $model->findAll()->toArray();
		$this->addAttributes('userList', $data);
		return view('/backyard/user/index')->with('attributes', $this->attributes);
	}

}