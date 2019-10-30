<?php


namespace TLLibs\Ctrl;


use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use TLLibs\Auth\WXAuth;
use TLLibs\Common\ApiCtrl;
use TLLibs\Format\LoginFormat;
use TLLibs\Models\User;

class AuthCtrl extends ApiCtrl
{

    /**
     * AuthCtrl constructor.
     */
    public function __construct()
    {
        $this->formatTransfer = new LoginFormat();
    }

    public function accountLogin(){
        $acct = Input::get('account',null);
        $pwd = Input::get('pwd',null);
        $user = User::where(function ($query) use ($acct, $pwd) {
            $query->where('phone', $acct)
                ->orWhere('email', $acct);
        })->first();
        if (empty($user)) {
            abort(404);
        }
        if ($pwd !== Crypt::decrypt($user->password)) {
            abort(403);
        }
        $user->token = Uuid::uuid();
        $user->save();
        return $this->toJsonItem($user);
    }

    public function weChatLogin()
    {
        $code = Input::get('code',null);
        $wxId = $_SERVER['wx_key'];
        $wxSecret = $_SERVER['wx_secret'];
        $wxOpenId = (new WXAuth($wxId,$wxSecret))->decryptData($code);
        if(empty($wxOpenId)){
            abort(404);
        }
        $user = User::firstOrCreate(['wx_id'=>$wxOpenId]);
        $user->token = Uuid::uuid();
        $user->save();
        return $this->toJsonItem($user);
    }


}