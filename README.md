#upload-laravel5

# [upload-laravel5](https://github.com/jiugeto/upload-laravel5) for Laravel 5.5.*

## 方法一：Composer安装
- 安装_ide_helper.php，在项目根目录，命令行执行：`composer require barryvdh/laravel-ide-helper`
- 然后在config/app.php的providers中添加：Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
- 在项目根目录，命令行执行：
```sql
php artisan clear-compiled
php artisan ide-helper:generate
php artisan optimize
```