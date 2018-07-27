<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;
use think\Validate;

class PublicController extends Controller
{	
	//登录功能
	public function login(){
		// echo md5("123456".config('password_salt'));die;
		//判断是否时post请求
		if(request()->isPost()){
			//接收数据
			$postData = input('post.');

			//1验证规则
			$rule = [
				//表单name名称=>验证规则(多个用 | 隔开)
				'username' => "require|length:4,8",
				'password' => "require",
				'captcha'  => "require|captcha"//验证码		
			];
			//2验证的错误提示信息
			$message = [
				//表单name名称.规则名 => '相对应的提示信息'
				'username.require' => '用户名必填',
				'username.length'  => '用户名长度在4-8之间',
				'password.require' => '密码必填',
				'captcha.require'  => '验证码必填',
				'captcha.captcha'  => '验证码错误'
			];
			//3实例化验证器对象，开始验证
			$validate = new Validate($rule,$message);
			//4判断是否验证成功
			$result = $validate->batch()->check($postData);
			//判断
			if(!$result){
				$this->error(implode(',',$validate->getError()));
			}
			//调用模型方法checkUser，检测用户名和密码是否匹配
			$userModel = new User();
			$flag = $userModel->checkUser($postData['username'],$postData['password']);
			if($flag){
				//直接重定向到后台首页
				$this->redirect('admin/index/index');
			}else{
				$this->error('用户名或者密码错误');
			}
		}
		return $this->fetch();
	}

	//退出登录
	public function logout(){
		//清楚·session信息
		//session('user_id',null) 清楚某个session值
		session(null);
		$this->redirect('/login');
	}
}