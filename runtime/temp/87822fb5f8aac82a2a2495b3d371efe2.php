<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:57:"E:\tp5\public/../application/admin\view\category\upd.html";i:1532659906;}*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>无标题文档</title>
    <link href="/static/admin/css/style.css" rel="stylesheet" type="text/css" />
    <script language="JavaScript" src="/static/admin/js/jquery.js"></script>
    <style>
        .active{
            border-bottom: solid 3px #66c9f3;
        }
    </style>
</head>

<body>
    <div class="place">
        <span>位置：</span>
        <ul class="placeul">
            <li><a href="#">首页</a></li>
            <li><a href="#">表单</a></li>
        </ul>
    </div>
    <div class="formbody">
        <div class="formtitle">
            <span class="active">基本信息</span>
        </div>
        <form action="" method="post">
            <input type="hidden" name="cat_id" value="<?php echo $catData['cat_id']; ?>">
            <ul class="forminfo">
                <li>
                    <label>分类名称</label>
                    <input name="cat_name" placeholder="请输入分类名称" type="text" value="<?php echo $catData['cat_name']; ?>" class="dfinput" />
                </li>
                <li>
                    <label>父分类</label>
                    <select name="pid" class="dfinput">
                        <option value=''>请选择父分类</option>
                        <option value='0'>顶级分类</option>
                        <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): if( count($cats)==0 ) : echo "" ;else: foreach($cats as $key=>$cat): ?>
                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo str_repeat('&nbsp;',$cat['level']*4); ?><?php echo $cat['cat_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script type="text/javascript">
    $("select[name=pid]").val("<?php echo $catData['pid']; ?>");
</script>
    
</html>
