<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:59:"E:\tp5\public/../application/admin\view\category\index.html";i:1532682430;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $(".click").click(function() {
            $(".tip").fadeIn(200);
        });

        $(".tiptop a").click(function() {
            $(".tip").fadeOut(200);
        });

        $(".sure").click(function() {
            $(".tip").fadeOut(100);
        });

        $(".cancel").click(function() {
            $(".tip").fadeOut(100);
        });

    });
    </script>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">数据表</a></li>
            <li><a href="#">基本内容</a></li>
        </ul>
    </div>
    <div class="rightinfo">
        <div class="tools">
            <ul class="toolbar">
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t01.png" /></span>添加</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t02.png" /></span>修改</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t03.png" /></span>删除</li>
                <li><span><img src="<?php echo config('admin_static'); ?>/images/t04.png" /></span>统计</li>
            </ul>
        </div>
        <table class="tablelist">
            <thead>
                <tr>
                    <th>
                        <input name="" type="checkbox" value="" id="checkAll" />
                    </th>
                    <th>序号</th>
                    <th>分类名称</th>
                    <th>父分类</th>
                    <th>创建时间</th>
                    <th>修改时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): if( count($cats)==0 ) : echo "" ;else: foreach($cats as $key=>$cat): ?>
                <tr>
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo str_repeat('&nbsp;',$cat['level']*4); ?><?php echo $cat['cat_name']; ?></td>
                    <td><?php echo !empty($cat['p_name'])?$cat['p_name']:'顶级分类'; ?></td>
                    <td><?php echo $cat['create_at']; ?></td>
                    <td><?php echo $cat['update_time']; ?></td>
                    <td><a href="<?php echo url('admin/category/upd',['cat_id'=>$cat['cat_id']]); ?>" class="tablelink">编辑</a> <a href="jascript:;" cat_id="<?php echo $cat['cat_id']; ?>" class="delCat tablelink"> 删除</a></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        
        <div class="tip">
            <div class="tiptop"><span>提示信息</span>
                <a></a>
            </div>
            <div class="tipinfo">
                <span><img src="<?php echo config('admin_static'); ?>/images/ticon.png" /></span>
                <div class="tipright">
                    <p>是否确认对信息的修改 ？</p>
                    <cite>如果是请点击确定按钮 ，否则请点取消。</cite>
                </div>
            </div>
            <div class="tipbtn">
                <input name="" type="button" class="sure" value="确定" />&nbsp;
                <input name="" type="button" class="cancel" value="取消" />
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.tablelist tbody tr:odd').addClass('odd');
        //ajax无刷新删除
        $(".delCat").on('click',function(){
            if(confirm('确认删除?')== false){
                return false;
            }
            var _self = $(this);//保存当前对象
            //获取自定义的属性cat_id
            var cat_id= _self.attr('cat_id');
            console.log(cat_id);
            //发送ajax请求进行删除
            $.get("<?php echo url('admin/category/ajaxDel'); ?>",{"cat_id":cat_id},function(res){
                console.log(res);
                if(res.code == 200){
                    //删除当前所在tr行给remove掉
                    _self.parents('tr').remove();
                }else{
                    alert(res.message);
                }
            },'json');
        });
    </script>
</body>

</html>
