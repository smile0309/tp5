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
    //封装通用的文件上传的方法
    public function uploadImg($fileName){
    	$ori_img = '';//存储原图的路径
    	$thumb_img = '';//存储缩略图的路径
    	//判断是否有文件上传
			if($file = request()->file($fileName)){
				//定义上传文件目录
				$uploadDir = './upload';
				//定义文件的验证规则
				$condition = [
					'size' => 1024*1024*2,
					'ext'  => 'png,jpg,gif,jpeg'
				];
				//上传验证并上传文件
				$info = $file->validate($condition)->move($uploadDir);
				//判断是否上传成功
				if($info){
					//成功，获取上传的目录文件信息，用于存储到数据库中
					$ori_img = $info->getSaveName();
					//生成缩略图
					$image = \think\Image::open('./upload/'.$ori_img);//打开需要生成缩略图的图片
					$arr_path = explode('\\',$ori_img);//把图片的目录以\方式炸开
					$thumb_path = $arr_path[0].'/thumb_'.$arr_path[1];//拼接缩略图的地址
					// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
					$image->thumb(150, 150)->save('./upload/'.$thumb_path);
					return ['ori_img'=>$ori_img,'thumb_img'=>$thumb_img];

				}else{
					//上传失败，提示信息
					$this->error($file->getError());
				}
			}
    }
}
