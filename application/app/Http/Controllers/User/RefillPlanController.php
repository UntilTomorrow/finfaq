<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\PricePlan;
use Illuminate\Http\Request;
use App\Models\GatewayCurrency;
use App\Http\Controllers\Controller;

class RefillPlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Buy-Credit';
        $user = User::where('id',auth()->user()->id)->with('posts.comments')->first();
        $gatewayCurrency = GatewayCurrency::whereHas('method', function ($gate) {
            $gate->where('status', 1);
        })->with('method')->orderby('method_code')->get();
        return view($this->activeTemplate . 'user.payment.refill_plan', compact('gatewayCurrency', 'pageTitle','user','gatewayCurrency'));
    }
}
