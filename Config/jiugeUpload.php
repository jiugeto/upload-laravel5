<?php
/**
 * jiuge上传的配置文件
 */
return array(
    'to' => 'local', //上传目标：local，ali，qiniu
    'domain' => '', //上传到的域名
    'uploadSizeLimit' => '', //上传的文件大小限制
    'suffixImg' => array(), //上传的文件后缀
    'ali' => array(
        'accessKeyId' => '',
        'accessKeySecret' => '',
        'bucket' => '',
    ),
    'qiniu' => array(
        'accessKey' => '',
        'secretKey' => '',
        'BucketName' => '',
    ),

//    'wiki' => array(
//        'name' => 'wiki',
//        'content' => 'Welcome to the Amaze UI wiki!',
//    ),
);