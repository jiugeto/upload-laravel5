<?php
/**
 * jiuge上传的配置文件
 */
return array(
    'to' => 'local', //上传目标：local，ali，qiniu
    'ali' => array(
        'accessKeyId' => '',
        'accessKeySecret' => '',
        'endpoint' => '',
        'bucket' => '',
        'uploadSizeLimit' => '',
        'suffixImg' => '',
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