<?php

namespace App\Http\Controllers\Cms;

use App\Models\Customer;
use App\Helpers\ImageHelper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $model = Customer::get();
        return view('cms.customer.index', [
            "data" => $model
        ]);
    }

    public function create()
    {
        return view('cms.customer.create');
    }

    public function store(Request $request) 
    {
        try {

            DB::beginTransaction();

            $model = new Customer;

            if($request->hasFile('photo'))
            {
                $photo = $request->file('photo');
                $path_photo = ImageHelper::uploadFile($photo, 'customer');
                $model->photo = $path_photo;
            }

            $model->nomor_ktp = $request->nomor_ktp;
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone_number = $request->phone_number;
            $model->institution = $request->institution;
            $model->address = $request->address;
            $model->notes = $request->notes;
            $model->save();

            DB::commit();

            return redirect(route('customer.index'))->with("message", "Saved");

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function edit($id) 
    {
        $model = Customer::where('id', $id)->first();
        return view('cms.customer.edit', [
            "data" => $model
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {

            DB::beginTransaction();

            $model = Customer::where('id', $id)->first();

            if($request->hasFile('photo'))
            {
                $photo = $request->file('photo');
                $path_photo = ImageHelper::uploadFile($photo, 'customer');
                ImageHelper::removeFilesFromDirectories($model->photo);
                $model->photo = $path_photo;
            }

            $model->nomor_ktp = $request->nomor_ktp;
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone_number = $request->phone_number;
            $model->institution = $request->institution;
            $model->address = $request->address;
            $model->notes = $request->notes;
            $model->save();

            DB::commit();

            return redirect(route('customer.index'))->with("message", "Update");

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
}
