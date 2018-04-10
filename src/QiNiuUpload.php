<?php
namespace JiugeTo\UploadLaravel5;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class QiniuUpload
{
    /**
     * 七牛的上传工具类
     */

    /**
     * 只上传图片，返回图片地址
     * @return string
     */
    public static function uploadOnlyImg($request,$imgName='url_ori')
    {
        $uploadSizeLimit = 10 * 1024 * 1023;//限制上传图片尺寸10M
        if($request->hasFile($imgName)){//判断图片存在
            if ($_FILES[$imgName]['size'] > $uploadSizeLimit) {
                echo "<script>alert('图片过大！');history.go(-1);</script>";exit;
            }
            $file = $request->file($imgName);           //获取图片
            return QiniuUpload::uploadFileToQiniu($file,$imgName);
        } else {
            return '';
        }
    }

    /**
     * 生成七牛上传凭证
     * @return string
     */
    private static function getToken()
    {
        $accessKey = config('qiniu.accessKey');
        $secretKey = config('qiniu.secretKey');
        $auth = new Auth($accessKey, $secretKey);
        $bucket = config('qiniu.bucket');//上传空间名称
        return $auth->uploadToken($bucket);//生成token
    }

    /**
     * 文件上传到七牛
     */
    public static function uploadFileToQiniu($file,$imgName)
    {
        if (!$file) { return ''; }
        $token = QiniuUpload::getToken();
        $uploadManager=new UploadManager();
        $name = date('Ymd',time()).'-'.uniqid().'.'.$file->getClientOriginalExtension();
        $filePath = $_FILES[$imgName]['tmp_name'];
        $type = $_FILES[$imgName]['type'];
        list($ret,$err) = $uploadManager->putFile($token,$name,$filePath,null,$type,false);
        if($err){//上传失败
            dd($err);
        }else{//成功
            return config('qiniu.domain').'/'.$ret['key'];
        }
    }

    /**
     * 删除七牛上对应的文件
     */
    public static function deleteFile($path)
    {
        if (!$path) { return ''; }
        $accessKey = config('qiniu.accessKey');
        $secretKey = config('qiniu.secretKey');
        $bucket = config('qiniu.bucket');
        $auth = new Auth($accessKey, $secretKey);
        $bucketMgr = new BucketManager($auth);
        $files = explode('/',$path);
        $file = $files[count($files)-1];
        $rstQiniu = $bucketMgr->delete($bucket, $file);
        if ($rstQiniu !== null) {
            return false;
        } else {
            return true;
        }
    }
}