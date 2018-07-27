<?php 
namespace app\admin\model;
use think\Model;
class Category extends Model{
	//指定当前模型的主键字段
	protected $pk = "cat_id";
	//时间自动维护
	protected $autoWriteTimestamp = true;
	//
	protected $createTime = 'create_at';

	//无限递归分类方法
	/*
	 * $data   需要分类的数据
	 * $pid    父类id  默认为0 顶级分类
	 * $level  层级关系  顶级分类为0  一级分类为1  类推
	 */	
	public function getSonCat($data,$pid=0,$level=1){
		static $result = [];//静态数组，只会初始化一次
		foreach($data as $v){
			//第一次循环一定找到pid=0的顶级
			if($v['pid'] == $pid){
				$v['level'] = $level;//加一个层级关系
				$result[] = $v;//存放在数组中
				$this->getSonCat($data,$v['cat_id'],$level+1);

			}
		}
		//返回递归处理好的数据
		return $result;
	}
}