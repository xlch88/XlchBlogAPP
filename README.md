# XlchBlogAPP
基于vue.js的wordpress博客app

# 图片
![qwq](https://xlch.me/wp-content/uploads/2018/07/201807272344.png)

# 安装
将php/xlch_blog.sql导入到你的博客数据库

将php/api.php上传到你的wordpress根目录，打开后修改new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)为你的数据库信息。

修改vue代码中的所有https://xlch.me/api.php为http://你的网站地址/api.php

编译即可。
