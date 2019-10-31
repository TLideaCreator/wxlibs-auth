<?php


namespace TLLibs\API\WX;



use Curl\Curl;

class WXApi
{
    private static $_instance = null;
    private $appId = null;
    private $appSecret = null;

    CONST TYPE = [
        'auth' =>[
            'method'=>'get',
            'url'=> "https://api.weixin.qq.com/sns/jscode2session?appid=APP_ID&secret=APP_SECRET&js_code=ENCODE&grant_type=authorization_code"
        ],

    ];

    /**
     * WXApi constructor.
     */
    private function __construct()
    {
        $this->appId = env('WX_KEY');
        $this->appSecret = env('WX_SECRET');;
    }

    /**
     * @return WXApi|null
     */
    public static function getInstance(){
        if(self::$_instance == null){
            self::$_instance = new WXApi();
        }
        return self::$_instance;
    }

    public function decryptData($code, $type){
        try{
            $curl = new Curl();
            $typeItem = self::TYPE[$type];
            $url = str_replace('ENCODE',$code,$typeItem['url']);
            $url = str_replace('APP_ID',$this->appId, $url);
            $url = str_replace('APP_SECRET',$this->appSecret, $url);
            if($typeItem['method']=== 'get' ){
                $request = $curl->get($url);
            }
            $request = json_decode($request,true);
            return $request;
        }catch (\Exception $exception){
            return null;
        }
    }

}