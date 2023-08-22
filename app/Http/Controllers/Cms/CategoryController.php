<?php

namespace App\Http\Controllers\Cms;

use Config;
use Carbon\Carbon;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $model = Category::orderBy('id');
        if ($request->has('filter')) {
            if (in_array( $request->input('filter'), ["active", "nonactive"])) {
                $model->where('status','=', $request->input('filter'));
            } else {
                abort(404);
            }
        }

        $data = $model->paginate(10);
        
        return view('cms.category.index', [
            "data" => $data
        ]);
    }

    public function store(Request $request)
    {
        $model = new Category;
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        return redirect(route('category.index'))->with("message", "Saved");
    }

    public function edit(Request $request)
    {
        return view('cms.category.edit', [
            "model" => $request->datamaster
        ]);
    }

    public function update(Request $request, $id)
    {
        $model = Category::where('id', $id)->first();
        $model->name = $request->name;
        $model->status = $request->status;
        $model->save();

        return redirect(route('category.index'))->with("message", "Updated");
    }

    public function destroy(Request $request, $id)
    {
        try {            
            $model = Category::find($id);
            $model->forceDelete();

            return response()->json([
                'status' => true,
                'message' => 'Data Deleted',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
