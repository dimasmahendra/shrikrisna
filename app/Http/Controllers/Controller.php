<?php

namespace App\Http\Controllers;

use App\Models\CategoryDetails;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
	{
		$name = Route::currentRouteName();
        if ($name != "category.details" && $name != "category.details.store" && $name != "category.details.edit" && $name != "category.details.update" && $name != "category.details.destroy"
        && $name != "category.details.cancel" && $name != "category.details.submit") {
            CategoryDetails::where("is_temporary", 1)->delete();
        }
	}
}
