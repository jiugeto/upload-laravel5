#upload-laravel5

# [upload-laravel5](https://github.com/jiugeto/upload-laravel5) for Laravel 5.5.*

## Composer安装
- 安装_ide_helper.php，在项目根目录，命令行执行：`composer require barryvdh/laravel-ide-helper`
- 然后在config/app.php的providers中添加：Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class,
- 在项目根目录，命令行执行：
```sql
php artisan clear-compiled
php artisan ide-helper:generate
php artisan optimize
```
安装jiugeto/upload-laravel5：
然后在项目中，命令行执行：composer require jiugeto/upload-laravel5:dev-master

## 使用方式
use JiugeTo\UploadLaravel5\Upload;
Upload::upload($request,$fileName);
- 说明：
-       $request是 use Illuminate\Http\Request;
-       $fileName是 表单里面的文件字段名称 name=""
#返回结果是上传完毕的文件地址
#将jiugeto\UploadLaravel5\Config\jiugeUpload.php文件拷贝到config目录中，并填写好对应参数
#阿里云OSS、七牛云存储，都要先注册对应账号，
#然后获取对应的域名DOMAIN、账号KEY、密钥SECRET、存储块BUCKET