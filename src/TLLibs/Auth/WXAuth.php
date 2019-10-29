<?php
namespace TLLibs\Auth;

use Curl\Curl;

class WXAuth{
    private $appId;
    private $appSecret;

    /**
     * WXAuth constructor.
     * @param $appId
     * @param $appSecret
     */
    public function __construct($appId, $appSecret)
    {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function decryptData($code){
        try{
            $curl = new Curl();
            $request = $curl->get("https://api.weixin.qq.com/sns/jscode2session?appid={$this->appId}&secret={$this->appSecret}&js_code={$code}&grant_type=authorization_code");
            $request = json_decode($request,true);
            return isset($request['openid'])? $request['openid']:null;
        }catch (\Exception $exception){
            return null;
        }
    }

}