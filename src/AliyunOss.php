<?php
namespace JiugeTo\UploadLaravel5;

use OSS\OssClient;
use OSS\Core\OssException;

class AliyunOss
{
    /**
     * 阿里云对象管理
     * 阿里云OSS管理：https://oss.console.aliyun.com/bucket/oss-cn-hangzhou/dongzhan-admin/object?path=uploads%2F
     */

//    protected static $accessKeyId = '';
//    protected static $accessKeySecret = '';
////    public static $endpoint = '';
//    public static $bucket = '';

    public function __construct()
    {
    }

    /**
     * 图片上传
     */
    public static function uploadImg($request,$imgName='img')
    {
//        $uploadSizeLimit = 10 * 1024 * 1023; //限制上传图片尺寸10M
//        $suffix_img = [//图片允许后缀
//            "png", "jpg", "gif", "bmp", "jpeg", "jpe",
//        ];
        $uploadSizeLimit = Config('jiugeUpload.ali.uploadSizeLimit');
        $suffix_img = Config('jiugeUpload.ali.suffixImg');
        if($request->hasFile($imgName)){ //判断图片存在
            if ($_FILES[$imgName]['size'] > $uploadSizeLimit) {
                echo "<script>alert('图片过大！');history.go(-1);</script>";exit;
            }
            $file = $request->file($imgName); //获取图片
            if($file->isValid()){
                if ($file->getClientOriginalExtension() &&
                    !in_array($file->getClientOriginalExtension(), $suffix_img)) {
                    echo "<script>alert('你的图片格式不对！');history.go(-1);</script>";exit;
                }
                $extension       = $file->getClientOriginalExtension() ?: 'png';
                $folderName      = 'uploads/images/'.date('Ymd',time()).'/';
                $safeName        = uniqid().'.'.$extension;
                //OSS存储空间名称
                $bucket = Config('jiugeUpload.ali.bucket');
                //OSS目标目录
                $object = $folderName.$safeName;
                //本地服务器目录
                $path = $file->getPathName();
                //实例化OSS对象
                $ossClient = self::getOssClient();
                if (is_null($ossClient)) exit(1);
                //上传到OSS
                $resOss = $ossClient->uploadFile($bucket, $object, $path);
                if (!isset($resOss['oss-request-url']) || !$resOss['oss-request-url']) {
                    return '';
                }
                return $resOss['oss-request-url'];
            }
        }
        return '';
    }

    /**
     * OSS上面图片删除
     * ossKey，文件路径+文件名
     */
    public static function deleteObject($ossKey)
    {
        //截取阿里云OSS内网文件地址
        $ossKey = explode('/',$ossKey);
        unset($ossKey[0]); unset($ossKey[1]); unset($ossKey[2]);
        $ossKey = implode('/',$ossKey);
        //实例化OSS对象
        $ossClient = self::getOssClient();
        //干掉图片
        $resOss = $ossClient->deleteObject(Config('jiugeUpload.ali.bucket'), $ossKey);
        if (!$resOss) { return false; }
        return true;
    }

    /**
     * 实例化OSS对象
     */
    public static function getOssClient()
    {
        $accessKeyId = Config('jiugeUpload.ali.accessKeyId');;
        $accessKeySecret = Config('jiugeUpload.ali.accessKeySecret');;
        try {
            $ossClient = new OssClient($accessKeyId, $accessKeySecret, Config('jiugeUpload.ali.domain'));
        } catch (OssException $e) {
            printf(__FUNCTION__ . "creating OssClient instance: FAILED\n");
            printf($e->getMessage() . "\n");
            return null;
        }
        return $ossClient;
    }

//    /**
//     * 图片上传，本地上传到OSS
//     */
//    public static function uploadImgByLocal($imgPath)
//    {
//        $img = $imgPath;
//        //OSS存储空间名称
//        $bucket = self::$bucket;
//        //OSS目标目录
//        $imgArr = explode('/',$img);
//        $object = 'uploads/images/'.date('Ymd',time()).'/'.$imgArr[count($imgArr)-1];
//        //本地服务器目录
//        $path = ltrim($img,'/');
//        //实例化OSS对象
//        $ossClient = self::getOssClient();
//        if (is_null($ossClient)) exit(1);
//        //上传到OSS
//        $resOss = $ossClient->uploadFile($bucket, $object, $path);
//        if (!isset($resOss['oss-request-url']) || !$resOss['oss-request-url']) { return ''; }
//        return $resOss['oss-request-url'];
//    }
}