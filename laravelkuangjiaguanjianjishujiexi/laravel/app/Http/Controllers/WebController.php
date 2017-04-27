<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/4/26
 * Time: 下午11:03
 */

namespace App\Http\Controllers;


use App\Models\TbCategory;
use App\Models\TbRecords;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;


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

	public function index()
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

	public function getCategorylist()
	{
		$model = new TbCategory();
		$data  = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('catList', $data);
		return view("/backyard/category/index")->with('attributes', $this->attributes);
	}

	public function getCategoryadd()
	{
		return view("/backyard/category/add")->with("attributes", $this->attributes);
	}

	public function postCategoryadd()
	{
		$model          = new TbCategory();
		$param          = $_POST;
		$param['uid']   = $this->getAttribute('uid');
		$param['count'] = 0;
		$param['state'] = TbCategory::$state['use'];
		$model->categoryAdd($param);
		return redirect("/web/categorylist");
	}

	public function getDeletecat($cid)
	{
		$model          = new TbCategory();
		$nextId         = $model->deleteCat($this->getAttribute('uid'), $cid);
		$remodel        = new TbRecords();
		$num            = $remodel->changeCat($this->getAttribute('uid'), $cid, $nextId);
		$nextCat        = $model->find($nextId);
		$nextCat->count = $nextCat->count + $num;
		$nextCat->save();
		return redirect("/web/categorylist");
	}

	public function getNodeslist($cid = 0)
	{
		$model = new TbRecords();
		$data  = $model->findUserAll($this->getAttribute('uid'), $cid);
		$this->addAttributes("recordsList", $data);
		return view("/backyard/notes/index")->with("attributes", $this->attributes);
	}

	public function getNodesadd(){
		$model = new TbCategory();
		$data = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('cglist',$data);
		return view("/backyard/notes/add")->with('attributes',$this->attributes);
	}

	public function postNotesinsert(){
		$validator = $this->validator(Request::all());
		if($validator->fails()){
			$this->throwValidationException(
				Request::instance(),$validator
			);
		}
		$model = new TbCategory();
		$param = $_POST;
		$param['uid'] = $this->getAttribute('uid');
		$param['cid'] = (!empty($param['cid']))?$param['cid']:$model->firstOrNewId($this->getAttribute('uid'));
		$param['addtime'] = time();
		$param['state'] = 1;
		$rmodel = new TbRecords();
		$suc = $rmodel->insert($param);
		if($suc){
			return redirect("/web/noteslist");
		}else{
			return redirect("/web/notesadd");
		}
	}

	private function validator(array $data){
		return Validator::make($data,[
			'title'=>'required|max:255',
			'content'=>'required'
		]);
	}

	public function getDeletenote($id){
		$model = TbRecords::find($id);
		$model->state = TbRecords::$state['delete'];
		$cid = $model->cid;
		$model->save();
		$catModel = new TbCategory();
		$catModel->countReduce($cid,1);
		return redirect("/web/noteslist");
	}

	public function getNodeedit($id){
		$model = new TbCategory();
		$catData = $model->findUserAll($this->getAttribute('uid'));
		$this->addAttributes('cglist',$catData);
		$model = TbRecords::find($id);
		$data = $model->toArray();
		$data['attributes'] = $this->attributes;
		return view("/backyard/notes/edit",$data);
	}

	public function postNodechange($id){
		$model = TbRecords::find($id);
		$model->fill($_POST);
		$model->save();
		return redirect("/web/noteslist");
	}

	public function getNodeshow($id){
		$model = TbRecords::find($id);
		$data = $model->getAttributes();
		$data['attributes'] = $this->attributes;
		return view('/backyard/notes/show',$data);
	}



}