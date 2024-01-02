<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\PricePlan;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;

class PricePlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Buy-Credit';
        $user = User::where('id',auth()->user()->id)->with('posts.comments')->first();
        $pricePlan = PricePlan::where('status',1)->get();
        return view($this->activeTemplate . 'user.price-plan.price_plan', compact('pageTitle','user','pricePlan'));
    }

    public function insert(PricePlan $price_plan)
    {
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        $pageTitle = 'Deposit Methods';
        $user = User::where('id',auth()->user()->id)->with('posts.comments')->first();
        return view($this->activeTemplate . 'user.payment.price_plan', compact('gatewayCurrency', 'pageTitle','user','price_plan'));
    }
}
