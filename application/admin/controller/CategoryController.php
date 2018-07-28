<?php
namespace app\admin\controller;
use app\admin\model\Category;
use app\admin\model\Article;
use think\Validate;
class CategoryController extends CommonController{
	//添加分类方法
	public function add(){
		//实例化分类模型
		$catModel = new Category();
		//判断是否是post请求
		if(request()->isPost()){
			//接收post参数
			$postData = input('post.');
			// 使用单独的验证器类进行验证
			$result = $this->validate($postData,'Category.add',[],true);
			if($result !== true){
				//提示错误信息
				$this->error( implode(',',$result));
			}
			//验证通过之后数据入库
			if($catModel->save($postData)){
				$this->success('入库成功',url('admin/category/index'));
			}else{
				$this->error('入库失败');
			}

		}
		//获取所有分类，分配到模板
		$data = $catModel->select();
		//对分类数据进行递归处理（无限分类）
		$cats = $catModel->getSonCat($data);
		//返回视图，并分配数据
		return $this->fetch('',['cats'=>$cats]);
			
	}

	//列表分类方法
	public function index(){
		//实例化模型
		$catModel = new Category();
		//查询数据
		$data = $catModel
				->field('t1.*,t2.cat_name p_name')
				->alias('t1')
				->join('tp_category t2','t1.pid=t2.cat_id','left')
				->select();
		//进行无线递归分类处理
		$cats = $catModel->getSonCat($data);
		//展示数据并分配数据出去
		return $this->fetch('',['cats'=>$cats]);
	}
	//编辑功能
	public function upd(){
		//实例化模型
		$catModel = new Category();
		//判断是否是post请求
		if(request()->isPost()){
			//接收表单参数
			$postData = input('post.');
			//验证器验证
			$result = $this->validate($postData,"Category.upd",[],true);
			//判断验证是否成功
			if($result !== true){
				$this->error(implode(',',$result));
			}
			//入库并判断是否成功
			if($catModel->update($postData)){
				//编辑成功的提示信息和跳转地址
				$this->success('编辑成功',url('admin/category/index'));
			}else{
				$this->error('编辑失败');
			}
		}
		//接收参数
		$cat_id = input('cat_id');
		//根据id查询数据
		$catData = $catModel->find($cat_id);
		//获取所有分类数据
		$data = $catModel->select();
		//无限递归分类处理
		$cats = $catModel->getSonCat($data);
		return $this->fetch('',['cats'=>$cats,'catData'=>$catData]);

	}
	//ajax删除分类方法
	public function ajaxDel(){
		//判断是否ajax请求
		if(request()->isAjax()){
			// 1接收参数 cat_id
			$cat_id = input('cat_id');
			// 2判断是否有子分类
			$where = ['pid'=>$cat_id];
			//查找数据
			$result1 = Category::where($where)->find();
			//判断
			if($result1){
				//说明有子分类
				$response = ['code'=>-1,'message'=>'分类下有子分类，无法删除'];
				return json($response);die;
			}
			//判断分类下是否有文章
			$result2 = Article::where(['cat_id'=>$cat_id])->find();
			//判断
			if($result2){
				//说明有文章
				$response = ['code'=>-2,'message'=>'分类下有文章，无法删除'];
				return json($response);die;
			}
			if(Category::destroy($cat_id)){
				$response = ['code'=>200,'message'=>'删除成功'];
				return json($response);die;
			}else{
				$response = ['code'=>-3,'message'=>'删除失败'];
				return json($response);die;
			}
		}
	}
	
}