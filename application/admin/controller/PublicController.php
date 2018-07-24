<?php
namespace app\admin\controller;
use think\Controller;

class PublicController extends Controller
{
	public function login(){
		return $this->fetch();
	}
}