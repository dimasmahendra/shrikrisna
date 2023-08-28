<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Category;

class MeasurementController extends Controller
{
    public function category($id)
    {
        $model = Category::where('id', $id)->active()->first();
        return view('cms.measurement.layout', [
            "data" => $model
        ]);
    }
    
    public function create($id)
    {
        $model = Customer::where('id', $id)->first();
        $category = Category::has('details')->active()->get();
        return view('cms.measurement.create', [
            "data" => $model,
            "category" => $category,
        ]);
    }
}
