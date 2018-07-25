<?php
namespace app\admin\model;
use think\Model;
class User extends Model{
	/**
	 * 检测用户名和密码是否匹配的方法
	 * $username 用户名
	 * $password 密码
	 * return 成功返回true 失败返回false
	 */
	public function checkUser($username,$password){
		$where = [
			'username' => $username,
			'password' => md5($password.config('password_salt')),
		];
		$userInfo = $this->where($where)->find();//find()返回一个对象模型
		if($userInfo){
			//用户信息保存在session中
			session('user_id',$userInfo['user_id']);
			session('username',$userInfo['username']);
			return true;
		}else{
			return false;
		}
	}
}