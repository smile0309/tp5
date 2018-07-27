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
				->select();
		return $this->fetch('',['datas'=>$datas]);
	}
	//文章编辑方法
	public function upd(){
		//实例化模型
		$artModel = new Article();
		$catModel = new Category();
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
	//ajax删除文章内容
	public function ajaxDel(){
		//判断是否是Ajax请求
		if(request()->isAjax()){
			//接收传递来的article_id
			$article_id = input('article_id');
			//判断是否删除成功
			if(Article::destroy($article_id)){
				$response = ['code'=>200,'message'=>'删除成功'];
				return json($response);die;
			}else{
				$response = ['code'=>-1,'message'=>'删除失败'];
				return json($response);die;
			}
		}
	}
}