<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\User;

class PublicController extends Controller
{	
	//登录功能
	public function login(){
		// echo md5("123456".config('password_salt'));die;
		//判断是否时post请求
		if(request()->isPost()){
			//接收数据
			$postData = input('post.');
			// dump($postData);die;
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