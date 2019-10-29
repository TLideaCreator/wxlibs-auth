<?php


namespace TLLibs\Auth;


use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Crypt;
use TLLibs\Models\User;

class UserAuth
{

    public function accountLogin($acct, $pwd){
        $user = User::where(function ($query) use ($acct, $pwd) {
            $query->where('phone', $acct)
                ->orWhere('email', $acct);
        })->first();
        if (empty($user)) {
            return null;
        }
        if ($pwd !== Crypt::decrypt($user->password)) {
            return null;
        }
        $user->token = Uuid::uuid();
        $user->save();
        return $user;
    }

    public function weChatLogin($wxOpenId)
    {
        $user = User::firstOrCreate(['wx_id'=>$wxOpenId]);
        $user->token = Uuid::uuid();
        $user->save();
        return $user;
    }
}