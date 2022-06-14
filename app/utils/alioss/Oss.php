<?php

namespace app\utils\alioss;
use OSS\OssClient;
use OSS\Core\OssException;

class Oss 
{
    // 阿里云账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM用户进行API访问或日常运维，请登录RAM控制台创建RAM用户。
    private $accessKeyId = "LTAI5tEmx7LWkSoZWQM4jPhp";
    private $accessKeySecret = "hFvWnX6AQ5qP7xAuWnLcXOqMegx7Jd";
    // yourEndpoint填写Bucket所在地域对应的Endpoint。以华东1（杭州）为例，Endpoint填写为https://oss-cn-hangzhou.aliyuncs.com。
    private $endpoint = "https://oss-cn-shenzhen.aliyuncs.com";
    // 填写Bucket名称，例如examplebucket。
    private $bucket = "dian-ji";
    // 填写Object完整路径，例如exampledir/exampleobject.txt。Object完整路径中不能包含Bucket名称。
    
    public function upload($NewfileName,$uploadFileUrl)
    {
        try 
        {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $url = $ossClient->uploadFile($this->bucket, $NewfileName, $uploadFileUrl);
            
            $rs['url'] = $url['info']['url'];
            $rs['name']= $NewfileName;
            return $rs;
            
        } catch (OssException $e) {
            return false;
        }
    }
    
    public function delete($fileName) 
    {
        try 
        {
            $ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
            $ossClient->deleteObject($this->bucket, $fileName);
        } catch (OssException $e) {
            return false;
        }
    }
}
