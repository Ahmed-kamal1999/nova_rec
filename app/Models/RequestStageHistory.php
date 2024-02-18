<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStageHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'old_stage', 'new_stage' ,'notes','order_id','user_id'
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
