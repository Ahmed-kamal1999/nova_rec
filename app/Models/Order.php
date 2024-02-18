<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public const STAGE_REJECTED = -1;
    public const STAGE_ONE = 0;
    public const STAGE_TOW = 1;
    public const STAGE_THERE = 2;
    public const STAGE_FOURE = 3;
    public const STAGE_FIVE = 4;

    public const China_receipt = 0;
    public const China_in_Processed = 1;
    protected $fillable = [
        'statusofwork'
    ];

    public static function stagesForNova()
    {
        return [
            self::STAGE_REJECTED => 'ملغي',
            self::STAGE_ONE => ' Stage One ',
            self::STAGE_TOW => '  Stage Tow',
            self::STAGE_THERE => ' Stage There ',
            self::STAGE_FOURE => ' Stage Foure ',
            self::STAGE_FIVE => ' Stage Five ',
        ];
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $latestRecord = static::latest('id')->first();
            $latestId = $latestRecord ? intval(substr($latestRecord->id, -4)) : 0;
            $formattedId = 'ORD' . str_pad($latestId + 1, 4, '0', STR_PAD_LEFT);
            $model->code = $formattedId;
        });
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class,'client_id');
    }
    public function polica(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Polica::class,'polisa_id');
    }
    public function history(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(RequestStageHistory::class, 'order_id');

    }
    public function quations(): \Illuminate\Database\Eloquent\Relations\hasMany
    {
        return $this->hasMany(RequestStageHistory::class, 'order_id');

    }
    public function quotes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Quotes::class,'order_id');
    }


}
