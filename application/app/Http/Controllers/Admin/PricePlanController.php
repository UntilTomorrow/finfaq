<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricePlan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PricePlanController extends Controller
{
    public function index()
    {
        $pageTitle = 'Price-Plan';
        $emptyMessage = "No data found";
        $data = PricePlan::paginate(getPaginate());
        return view('admin.price_plan.list', compact('pageTitle', 'data', 'emptyMessage'));
    }

    public function store(Request $request){
        $pageTitle = ' Create Price Plan';
        $plan = $this->rules($request);
        PricePlan::create([
            'name' => $plan['name'],
            'price' =>$plan['price'],
            'credit' =>$plan['credit'],
            'status' =>$plan['status']
        ]);
        $notify[] = ['success', 'Price Plan create successfully'];
        return to_route('admin.price.plan.all')->withNotify($notify);
    }

    public function update(Request $request, PricePlan $plan){

        $pageTitle = ' Price Plan Update';
        $data = $this->rules($request,$plan->id);
        $plan->name = $data['name'];
        $plan->price = $data['price'];
        $plan->credit = $data['credit'];
        $plan->status = $data['status'];
        $plan->save();
        $notify[] = ['success', 'Price Plan create successfully'];
        return to_route('admin.price.plan.all')->withNotify($notify);
    }

    private function rules($rules, $id=null){
        $data = $rules->validate([
            'name' =>"required|unique:price_plans,name,".$id,
            'price' =>"required",
            'credit' =>"required",
            'status' =>"required|".Rule::in(['1', '0']),
        ]);
        return $data;
    }

}
