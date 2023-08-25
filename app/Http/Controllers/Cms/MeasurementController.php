<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Category;

class MeasurementController extends Controller
{
    public function create($id)
    {
        $model = Customer::where('id', $id)->first();
        $category = Category::active()->get();
        return view('cms.measurement.create', [
            "data" => $model,
            "category" => $category,
        ]);
    }
}
