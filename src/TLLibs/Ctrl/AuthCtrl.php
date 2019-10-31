<?php


namespace TLLibs\Ctrl;


use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use TLLibs\API\WX\WXApi;
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

    public function accountLogin(Request $request){
        $acct = $request->input('account',null);
        $pwd = $request->input('pwd',null);
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

    public function weChatLogin(Request $request)
    {
        $code = $request->input('code',null);

        $authRequest = WXApi::getInstance()->decryptData($code, 'auth');
        if(empty($authRequest) || !isset($authRequest['openid'])){
            abort(404);
        }
        $user = User::firstOrCreate(['wx_id'=>$authRequest['openid']]);
        $user->token = Uuid::uuid();
        $user->save();
        return $this->toJsonItem($user);
    }


}