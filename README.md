# iBrand Laravel Backend

基于 [laravel-admin][1]  和 [inspinia-admin html template][2] 实现的管理后台。

> 2016年9月 iBrand 启动时，就使用 inspinia-admin html template 来作为管理后台UI，并且搭建一个类似 laravel-admin 的基础包，
但是因为时间紧张忙于功能研发，在扩展性上并不如 Laravel-admin，所以基于开源项目的启动，在开源项目中将基于 laravel-admin 来作为管理后台。

## Feature
基于 laravel-admin 进行了如下扩展：
1. 完全兼容 laravel-admin 开发方式
2. 后台主题使用 inspinia-admin
3. 支持顶部菜单
4. 默认安装了 helpers,scheduling,log-viewer,redis-manager,backup 5个扩展

## 安装

```
composer require ibrand/backend:~3.0 -vvv
```


### 低于 Laravel5.5 版本

`config/app.php` 文件中 `providers` 添加

```
iBrand\Backend\BackendServiceProvider::class,
```
`config/app.php` 文件中 `aliases` 添加

```
 'BackendMenu' => iBrand\Backend\Facades\Menu::class,
```

### 发布资源

```
php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
php artisan vendor:publish --provider="iBrand\Backend\BackendServiceProvider"
```

### 初始化数据库

```
php artisan ibrand:backend-install
```
该命令会自动执行 `php artisan admin:install`

### 安装插件

默认集成了 helpers,scheduling,log-viewer,redis-manager,backup 五个插件
```
php artisan ibrand:backend-install-extensions
```
会初始化五个插件的菜单



  [1]: https://github.com/z-song/laravel-admin
  [2]: http://webapplayers.com/inspinia_admin-v2.7.1/
