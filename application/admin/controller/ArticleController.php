<?php 
namespace app\admin\controller;
use app\admin\model\Category;
use app\admin\model\Article;
class ArticleController extends CommonController{
	//添加文章
	public function add(){
		//获取所有分类
		$catModel = new Category();
		$artModel = new Article();
		//判断是否是post请求
		if(request()->isPost()){
			//接收post参数
			$postData = input('post.');
			//单独验证器验证
			$result = $this->validate($postData,'Article.add',[],true);
			//判断是否验证成功
			if($result!==true){
				//提示错误信息
				$this->error( implode(',',$result) );
			}
			//判断是否有文件上传
			if($file = request()->file('img')){
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
					$postData['ori_img'] = $info->getSaveName();
					//生成缩略图
					$image = \think\Image::open('./upload/'.$postData['ori_img']);//打开需要生成缩略图的图片
					$arr_path = explode('\\',$postData['ori_img']);//把图片的目录以\方式炸开
					$thumb_path = $arr_path[0].'/thumb_'.$arr_path[1];//拼接缩略图的地址
					// 按照原图的比例生成一个最大为150*150的缩略图并保存为thumb.png
					$image->thumb(150, 150)->save('./upload/'.$thumb_path);
					//保存缩略图地址到数据库字段中
					$postData['thumb_img'] = $thumb_path;

				}else{
					//上传失败，提示信息
					$this->error($file->getError());
				}
			}
			//判断是否入库成功
			if($artModel->save($postData)){
				$this->success('入库成功',url('admin/article/index'));
			}else{
				$this->error('入库失败');
			}
		}
		//调用无限递归方法处理数据
		$cats = $catModel->getSonCat($catModel->select());
		return $this->fetch('',['cats'=>$cats]);
	}
	//文章列表页
	public function index(){
		//实例化文章模型类
		$artModel = new Article();
		//实例化分类模型类
		$catModel = new Category();

		//连表查询数据
		$datas = $artModel
				->alias('t1')
				->field('t1.*,t2.cat_name p_name')
				->join('tp_category t2','t1.cat_id=t2.cat_id','left')
				->paginate(2);
		return $this->fetch('',['datas'=>$datas]);
	}
	//文章编辑方法
	public function upd(){
		//实例化模型
		$artModel = new Article();
		$catModel = new Category();
		//判断是否是post请求
		if(request()->isPost()){
			//接收post参数
			$postData = input('post.');
			//验证器验证
			$result = $this->validate($postData,'Article.upd',[],true);
			if($result!==true){
				$this->error(implode(',',$result));
			}
			//验证成功之后，进行文件上传和缩略图的操作
			$path = $this->uploadImg('img');
			if($path){
				//删除原来的图片
				//获取原来图片的路径
				$oldData = $artModel->find($postData['article_id']);
				if($oldData['ori_img']){
					unlink('./upload/'.$oldData['ori_img']);
					unlink('./upload/'.$oldData['thumb_img']);
				}
				$postData['ori_img'] = $path['ori_img'];
				$postData['thumb_img'] = $path['thumb_img'];
			}
			//编辑入库
			if($artModel->update($postData)){
				$this->success("编辑成功",url('admin/article/index'));
			}else{
				$this->error('编辑失败');
			}
		}

		//接收传递的id
		$article_id = input('article_id');
		//根据id查询数据
		$artData = $artModel->find($article_id)->toArray();
		
		//获取所有分类数据
		$data = $catModel->select();
		//无限递归分类处理
		$cats = $catModel->getSonCat($data);
		return $this->fetch('',[
				'cats'    => $cats,
				'artData' => $artData
			]);
	}
	//删除文章内容
	public function ajaxDel(){
		//接收传递来的article_id
		$article_id = input('article_id');
		//根据ID获取数据
		$oldObj = Article::get($article_id);
		//删除原来的图片
		if($oldObj['ori_img']){
			unlink("./upload/".$oldObj['ori_img']);
			unlink("./upload/".$oldObj['thumb_img']);
		}
		//判断是否删除成功
		if($oldObj->delete()){
			$response = ['code'=>200,'message'=>'删除成功'];
			return json($response);die;
		}else{
			$response = ['code'=>-1,'message'=>'删除失败'];
			return json($response);die;
		}
	}
	//ajax获取文章内容
	public function getContent(){
		if(request()->isAjax()){
			//接收article_id
			$article_id = input('article_id');
			//获取文章内容
			$content = Article::where(['article_id'=>$article_id])->find();
			//返回json数据
			return json(['content'=>$content]);
		}
	}
	
}