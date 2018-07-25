<?php
namespace app\admin\controller;
use think\Controller;

class CommonController extends Controller
{
    //控制器的初始化方法（调用每个方法之前，都会出发此方法
    public function _initialize(){
        if(!session('user_id')){
            //没有提示用户登录才操作
            $this->success("请登录后才操作",url('/login'));
        }
    }
}
