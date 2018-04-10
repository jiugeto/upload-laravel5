<?php
namespace JiugeTo\UploadLaravel5;

use Illuminate\Http\Request;

class Upload
{
    /**
     * 上传工具
     * 切合 Laravel5
     */

    /**
     * 上传文件
     */
    public static function upload(Request $request,$fileName='img')
    {
        $to = Config('jiugeUpload.to');
        if ($to=='local') {
            return Local::uploadImg($request,$fileName);
        } else if ($to=='ali') {
            return AliyunOss::uploadImg($request,$fileName);
        } else if ($to=='qiniu') {
            return QiniuUpload::uploadOnlyImg($request,$fileName);
        } else {
            return '发生错误啦！';
        }
    }

    /**
     * 删除文件
     */
    public static function delete($path)
    {
        $to = Config('jiugeUpload.to');
        if ($to=='local') {
            return Local::delete($path);
        } else if ($to=='ali') {
            return AliyunOss::deleteObject($path);
        } else if ($to=='qiniu') {
            return QiniuUpload::deleteFile($path);
        } else {
            return '发生错误啦！';
        }
    }
}