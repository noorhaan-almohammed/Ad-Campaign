<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    protected $fillable = [
        'user_id','amount','status','method','account'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
