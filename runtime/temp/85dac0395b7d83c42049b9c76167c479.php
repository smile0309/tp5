<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:58:"E:\tp5\public/../application/admin\view\article\index.html";i:1532783977;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="<?php echo config('admin_static'); ?>/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo config('admin_static'); ?>/css/page.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo config('admin_static'); ?>/js/jquery.js"></script>
     <script type="text/javascript" src="/static/plugins/layer/layer.js"></script>
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
                    <th>文章标题</th>
                    <th>所属的分类</th>
                    <th>文章图片</th>
                    <th>内容</th>
                    <th>添加时间</th>
                    <th>修改时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($datas) || $datas instanceof \think\Collection || $datas instanceof \think\Paginator): if( count($datas)==0 ) : echo "" ;else: foreach($datas as $key=>$cat): ?>
                <tr height="80">
                    <td>
                        <input name="" type="checkbox" value="" />
                    </td>
                    <td><?php echo $key+1; ?></td>
                    <td><?php echo $cat['title']; ?></td>
                    <td><?php echo $cat['p_name']; ?></td>
                    <td><img width="100" src="/upload/<?php echo $cat['ori_img']; ?>"></td>
                    <td><a class="getContent" article_id="<?php echo $cat['article_id']; ?>" href="javascript:;">查看内容</a></td>
                    <td><?php echo $cat['create_time']; ?></td>
                    <td><?php echo $cat['update_time']; ?></td>
                    <td><a href="<?php echo url('admin/article/upd',['article_id'=>$cat['article_id']]); ?>" class="tablelink">编辑</a> <a href="jascript:;" article_id="<?php echo $cat['article_id']; ?>" class="delCat tablelink"> 删除</a></td>
                </tr>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
        <div class="pagin">
            <div class="message">共<i class="blue">1256</i>条记录，当前显示第&nbsp;<i class="blue">2&nbsp;</i>页</div>
           
                <?php echo $datas->render(); ?>
           
        </div>       
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
            var article_id= _self.attr('article_id');
            console.log(article_id);
            //发送ajax请求进行删除
            $.get("<?php echo url('admin/article/ajaxDel'); ?>",{"article_id":article_id},function(res){
                console.log(res);
                if(res.code == 200){
                    //删除当前所在tr行给remove掉
                    _self.parents('tr').remove();
                }else{
                    alert(res.message);
                }
            },'json');
        });

        //ajax查看文章内容
        $(".getContent").on('click',function(){
            //获取自定义的属性cat_id
            var article_id= $(this).attr('article_id');
            //发送ajax请求
            $.get("<?php echo url('admin/article/getContent'); ?>",{"article_id":article_id},function(res){
                console.log(res);
                layer.open({
                  type: 1,
                  skin: 'layui-layer-rim', //加上边框
                  area: ['800px', '500px'], //宽高
                  content: "<div style='padding:10px'>"+res.content.content+"</div>",
                  title:res.content.title
                });
            },'json');
        });

    </script>
</body>

</html>
