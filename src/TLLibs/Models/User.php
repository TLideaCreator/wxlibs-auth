<?php


namespace TLLibs\Models;


class User extends BaseModel
{

    protected $fillable = [
        'wx_id','wb_id','zfb_id','phone', 'email', 'password', 'nickname', 'avatar', 'is_admin', 'token'
    ];
    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];
}