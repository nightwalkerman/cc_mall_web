<?php

namespace app\utils\tools;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Request;

class JwtTools 
{ 
    //加密信息
    public static function encode($data = []) 
    {
$privateKey = <<<EOD
-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDMkbttp953auqB7QjTjVctHbrq2wnQ7dzw2i0PudO4f37ntWcE
VLudm19pRz43NaA6G/DRD6fQpiL/8psvPl3gd/nAzTAbFrdo7kyZ3OjeOiQhZORn
1ZsVblOt8yud0rmAmUkxZ1Yyn+QkJOu/i/sjvbEb7KWctLlumWVDXS/OOQIDAQAB
AoGAZ2dWrVQIUKabiTcumfi80xJPFD3J1XEWmCxAUM2mpoDTvf3k57yI5V7POKEJ
YtDZf+X1sUdPlVkVIfkY1iWZP2AoEZqhVB8tTX8CMbePOzlG9q1IBQmh+k+S6sRa
KCNByUqlu2VKxcEGn2WwcssyusebCEM8IJuL3dgCOC5EnwECQQD7TTAPKGoGpjSm
25sfX4ZZjwdfb7fNsGUKNXFQERyuD5njypGMokyFJ40EvyWh2YxDUK68jvy4Nl3H
8SC1/HvZAkEA0GTeTxUAOwPmP6tpcr81PLhPXVrEGFaZ2EAREr+HUoF6+sZE0/R8
3FDoS+RLvhYT0Pnq9NAYHjuKpAdpNlRJYQJBAN3gJamMbihWwK/9vvUxOwaBsOnD
Uo5Jyrv7uYMOyLqpzZ6AcIexmEwMQobJWamP0TZx2wViXaErZxusOsxTEukCQQDF
B4l0xctZAN/SNPPXDNd92FkZT7b1t/NvFWvPCQ0dwdQPhCQRLihbeZeYIXpHd8I2
pAQ0gQc8llkHqwYb2uchAkEAzzbo5blfM/XFQLVR3fxKyNmFrdGK+K2eZwXrDQcm
YI6pEookh3lOoxqRXPg58KswnY8Wv/GAa88Lwa1ewLfL7A==
-----END RSA PRIVATE KEY-----
EOD;
    
    
        $nowTime = time();
        $payload = array(
            "iat" => $nowTime,              // 设置当前时间
            "exp" => $nowTime + 31536000    // 有效期为1年
        );
        
        $payload = array_merge($payload,$data);
        
        $jwt = JWT::encode($payload, $privateKey, 'RS256');
        
        return $jwt;
    }
    
    //解密信息
    public static function decode($token) 
    {
$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDMkbttp953auqB7QjTjVctHbrq
2wnQ7dzw2i0PudO4f37ntWcEVLudm19pRz43NaA6G/DRD6fQpiL/8psvPl3gd/nA
zTAbFrdo7kyZ3OjeOiQhZORn1ZsVblOt8yud0rmAmUkxZ1Yyn+QkJOu/i/sjvbEb
7KWctLlumWVDXS/OOQIDAQAB
-----END PUBLIC KEY-----
EOD;
    
        try {
            //$request = Request::instance()->header();
            $decoded = JWT::decode($token, new Key($publicKey, 'RS256'));
            
            return $decoded;
        } catch (\Exception $exc) {
            return false;
        }
    }
}
