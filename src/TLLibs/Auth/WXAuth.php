<?php
namespace TLLibs\Auth;

use Curl\Curl;

class WXAuth{
    private $appId;
    private $appSecret;
    private static $_instance = null;
    /**
     * WXAuth constructor.
     * @param $appId
     * @param $appSecret
     */
    private function __construct()
    {
        $this->appId = env('WX_KEY');
        $this->appSecret = env('WX_SECRET');;
    }

    /**
     * @return WXAuth|null
     */
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new WXAuth();
        }
        return self::$_instance;
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