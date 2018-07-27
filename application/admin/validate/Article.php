<?php
namespace app\admin\validate;
use think\Validate;
//验证器类
class Article extends Validate{
	//定义验证规则
	protected $rule = [
		'title' => 'require|unique:article',//require 必填的 unique:category 在category表中是唯一的 
		'cat_id' => 'require'
	];
	//定义验证规则不通过的提示信息
	protected $message = [
		'title.require' => '标题不能为空',
		'title.unique'  => '标题名重复',
		'cat_id.require'      => '必须选择一个所属文章分类'
	];
	//定义验证场景
	protected $scene = [
		'add' => ['title','cat_id'],
	];
}