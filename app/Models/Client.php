<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{

    public const Coutomer = 0;
    public const Company = 1;


    use HasFactory;
    protected $fillable = [
        'name', 'id_name' ,'phone', 'city','type'
    ];

    public function order(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

}
