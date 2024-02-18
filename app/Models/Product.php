<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'code', 'name' ,'description',''
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $latestRecord = static::latest('id')->first();
            $latestId = $latestRecord ? intval(substr($latestRecord->id, -4)) : 0;
            $formattedId = 'PRO' . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT);
            $model->code = $formattedId;
        });
    }

    public function order(): \Illuminate\Database\Eloquent\Relations\belongsTo
    {
        return $this->belongsTo(Order::class,'order_id');
    }
    public function productquotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductQuotes::class);
    }

}
