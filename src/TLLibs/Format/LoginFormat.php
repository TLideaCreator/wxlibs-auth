<?php


namespace TLLibs\Format;


use TLLibs\Auth\TokenAuth;
use TLLibs\Models\User;
use League\Fractal\TransformerAbstract;

class LoginFormat extends TransformerAbstract
{

    public function transform(User $user)
    {
        $item = [
            'id' => $user->id,
            'name' => $user->nickname,
            'avatar' => $user->avatar,
            'phone' => $user->phone,
        ];
        if(!empty($user->token)){
            $item['token'] = TokenAuth::getInstance()->generateToken($user->token);
        }
        return $item;
    }

}