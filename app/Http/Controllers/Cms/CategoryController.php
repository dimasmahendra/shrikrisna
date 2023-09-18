<?php

namespace App\Http\Controllers\Cms;

use Auth;
use Config;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\CategoryDetails;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->id_role != 1) {
            abort(403);
        }

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

            CategoryDetails::where([
                ['id_master_category', '=', $id]
            ])->forceDelete();

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

    public function view($id) 
    {
        if (Auth::user()->id_role != 1) {
            abort(403);
        }

        $model = Category::where('id', $id)->first();
        $details = CategoryDetails::where('id_master_category', $id);
        return view('cms.category.view', [
            "data" => $model,
            "details" => $details->paginate(10)
        ]);
    }

    public function details($id) 
    {
        if (Auth::user()->id_role != 1) {
            abort(403);
        }
        
        $model = Category::where('id', $id)->first();
        $details = CategoryDetails::where('id_master_category', $id);
        $lastorder = ($details->max('order') == null) ? 1 : $details->max('order') + 1;
        $usedorder = array_column($details->get()->toArray(), 'order');
        
        return view('cms.category.details', [
            "data" => $model,
            "details" => $details->paginate(10),
            "lastorder" => $lastorder,
            "usedorder" => $usedorder
        ]);
    }

    public function detailsStore(Request $request, $id) 
    {
        $model = new CategoryDetails;
        $model->id_master_category = $id;
        $model->order = $request->order;
        $model->description = $request->description;
        $model->total_rows = $request->total_rows;
        $model->is_temporary = 1;
        $model->save();

        return redirect(route('category.details', [$id]))->with("message", "Saved")->with("show", "true");
    }

    public function detailsEdit(Request $request)
    {
        return view('cms.category.details.edit', [
            "model" => $request->datamaster
        ]);
    }

    public function detailsUpdate(Request $request, $id) 
    {
        $model = CategoryDetails::where('id', $id)->first();
        $model->order = $request->order;
        $model->description = $request->description;
        $model->total_rows = $request->total_rows;
        $model->save();

        return redirect(route('category.details', [$model->id_master_category]))->with("message", "Update")->with("show", "true");
    }

    public function detailsDestroy(Request $request, $id) 
    {
        try {            
            $model = CategoryDetails::find($id);
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

    public function detailsCancel(Request $request, $id) 
    {
        try {            
            CategoryDetails::where('id_master_category', $id)->where('is_temporary', 1)->forceDelete();
            return redirect(route('category.index'));
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function detailsSubmit(Request $request, $id) 
    {
        try {            
            CategoryDetails::where('id_master_category', $id)->update(['is_temporary' => 0]);
            return redirect(route('category.index'))->with("message", "Saved");
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
