<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:56:"E:\tp5\public/../application/admin\view\article\add.html";i:1532680999;}*/ ?>
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
        <form action="" method="post" enctype="multipart/form-data">
            <ul class="forminfo">
                <li>
                    <label>文章标题</label>
                    <input name="title" placeholder="请输入文章标题" type="text" class="dfinput" />
                </li>
                <li>
                    <label>所属分类</label>
                    <select name="cat_id" class="dfinput">
                        <option value=''>请选择一个分类</option>
                        <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): if( count($cats)==0 ) : echo "" ;else: foreach($cats as $key=>$cat): ?>
                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo str_repeat('&nbsp;',$cat['level']*4); ?><?php echo $cat['cat_name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </li>
                <li>
                    <label>文章图片</label>
                    <input name="img" id='f' type="file" onchange="change()" />
                    <p>
                        <img id="preview" alt="" width="200" name="pic" />
                    </p>
                </li>

                <li>
                    <label>文章描述</label>
                    <textarea style="margin-left:85px" id="container" name="content"></textarea>
                </li>
                
                    <label>&nbsp;</label>
                    <input name="" id="btnSubmit" type="submit" class="btn" value="确认保存" />
                </li>
            </ul>
        </form>
    </div>
</body>
<script language="JavaScript" src="/static/plugins/ueditor/ueditor.config.js"></script>
<script language="JavaScript" src="/static/plugins/ueditor/ueditor.all.js"></script>
<script language="JavaScript" src="/static/plugins/placeImage.js"></script>
<script type="text/javascript">
    var ue = UE.getEditor('container',{
        // toolbars: [
        //     ['fullscreen', 'source', 'undo', 'redo'],
        //     ['bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc']
        // ],
        initialFrameWidth:800,
        initialFrameHeight:300,
    });
</script>
</html>
