<?php


namespace App\Format;


use TLLibs\Auth\TokenCenter;
use TLLibs\Models\User;
use League\Fractal\TransformerAbstract;

class UserFormat extends TransformerAbstract
{

    public function transform(User $user)
    {
        $item = [
            'id' => $user->id,
            'name' => $user->nickname,
            'avatar' => $user->avatar,
            'phone' => $user->phone,
            'email' => $user->email,
        ];
        return $item;
    }

}