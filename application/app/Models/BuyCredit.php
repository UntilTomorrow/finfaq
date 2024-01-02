<?php

namespace App\Models;

use App\Models\User;
use App\Models\Deposit;
use App\Models\PricePlan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BuyCredit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function pricePlan(){
        return $this->belongsToMany(PricePlan::class);
    }

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function deposit(){
        return $this->belongsToMany(Deposit::class);
    }
}
