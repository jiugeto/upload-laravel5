<?php
namespace JiugeTo\UploadLaravel5;

class Local
{
    /**
     * 上传工具类
     */

    /**
     * 上传图片到本地/第三方图片服务器，返回图片地址
     * @return string
     */
    public static function uploadImg($request,$imgName='url_ori')
    {
        $uploadSizeLimit = 10 * 1024 * 1023;//限制上传图片尺寸10M
        if($request->hasFile($imgName)){//判断图片存在
            if ($_FILES[$imgName]['size'] > $uploadSizeLimit) {
                echo "<script>alert('图片过大！');history.go(-1);</script>";exit;
            }
            $file = $request->file($imgName);           //获取图片
            return self::uploadLocalImg($file);         //存储到本地
//            return QiniuUpload::uploadFileToQiniu($file,$imgName);
        } else {
            return '';
        }
    }

    /**
     * 这里是上传到本地
     * 上传方法，并处理文件
     * @return string
     */
    public static function uploadLocalImg($file)
    {
        $suffix_img = [//图片允许后缀
            "png", "jpg", "gif", "bmp", "jpeg", "jpe",
        ];
        if($file->isValid()){
            $allowed_extensions = $suffix_img;
            if ($file->getClientOriginalExtension() &&
                !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
                echo "<script>alert('你的图片格式不对！');history.go(-1);</script>";exit;
            }
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/images/'.date('Ymd', time()).'/';
            $destinationPath = public_path().$folderName;
            $safeName        = uniqid().'.'.$extension;
            $file->move($destinationPath, $safeName);
            return $folderName.$safeName;
        } else {
            return "";
        }
    }

    /**
     * 上传Excel返回图片地址
     * @return string
     */
    public static function uploadExcel($request,$imgName='excel')
    {
        $uploadSizeLimit = 10 * 1024 * 1023;//限制上传图片尺寸10M
        if($request->hasFile($imgName)){//判断图片存在
            if ($_FILES[$imgName]['size'] > $uploadSizeLimit) {
                echo "<script>alert('文件过大！');history.go(-1);</script>";exit;
            }
            $file = $request->file($imgName);           //获取图片
            return self::uploadLocalExcel($file);         //存储到本地
        } else {
            return '';
        }
    }

    /**
     * 这里是上传到本地
     * 上传方法，并处理文件
     * @return string
     */
    public static function uploadLocalExcel($file)
    {
        if($file->isValid()){
            if (!in_array($file->getClientOriginalExtension(),['xlsx','xls'])) {
                echo "<script>alert('你的文件格式不对！');history.go(-1);</script>";exit;
            }
            $extension       = $file->getClientOriginalExtension() ?: 'png';
            $folderName      = '/uploads/excels/';
            $destinationPath = public_path().$folderName;
            $safeName        = date('YmdHis',time()).rand(10,100).'.'.$extension;
            $file->move($destinationPath, $safeName);
            return $folderName.$safeName;
        } else {
            return "";
        }
    }

    /**
     * 干掉文件
     */
    public static function delete($path)
    {
        if (!$path) { return ''; }
        unlink(ltrim($path,'/'));
        return true;
    }
}