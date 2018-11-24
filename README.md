[![Latest Stable Version](https://poser.pugx.org/zks888/fecshop_couchbase/v/stable)](https://packagist.org/packages/zks888/fecshop_couchbase)
[![Total Downloads](https://poser.pugx.org/zks888/fecshop_couchbase/downloads)](https://packagist.org/packages/zks888/fecshop_couchbase)
[![Latest Unstable Version](https://poser.pugx.org/zks888/fecshop_couchbase/v/unstable)](https://packagist.org/packages/zks888/fecshop_couchbase)
[![License](https://poser.pugx.org/zks888/fecshop_couchbase/license)](https://packagist.org/packages/zks888/fecshop_couchbase)

Fecshop Couchbase购物车的实现

> fecshop 采用couchbase实现底层, 存储用户的cart信息。


安装
-------

```
composer require --prefer-dist zks888/fecshop_couchbase
```

or 在根目录的`composer.json`中添加

```
"zks888/fecshop_couchbase": "1.0.1"

```

然后执行

```
composer update
```

配置
-----

1.配置文件复制

将`vendor\zks888\fecshop_couchbase\config\fecshop_couchbase.php` 复制到
`@common\config\fecshop_third_extensions\fecshop_couchbase.php`(需要创建该文件)

该文件是扩展的配置文件，通过上面的操作，加入到fecshop的插件配置中

2.couchbase配置

[Couchbase 安装](https://github.com/matrozov/yii2-couchbase)

[Couchbase 中文资料](https://couchbase.shujuwajue.com/chapter1.html)

[Couchbase SDK-DOCTOR](https://github.com/couchbaselabs/sdk-doctor/releases/tag/v1.0.1)

[Couchbase 建索引](https://docs.couchbase.com/server/6.0/n1ql/n1ql-language-reference/createindex.html)

3.在couchbase中建立两个bucket，分别为：cart、item，

Access Control请选择Standard port (TCP port 11211. Needs SASL auth.) Enter password: 请不要设置

使用之前，请一定要先给cart建立cart_id的索引，item建立cart_id和product_id的联合索引，

因为couchbase在bucket没有建索引的情况下，查询是会报错的

4.然后，cart信息就存储到couchbase里面了，该扩展安装在路径 `vendor/zks888/fecshop_couchbase`下
