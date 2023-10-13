<?php

namespace App\Http\Controllers\Cms;

use App\Models\Customer;
use App\Helpers\ImageHelper;
use App\Models\Measurement;
use App\Models\FileMeasurement;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $model = Customer::select('id', 'name', 'nomor_ktp', 'phone_number')->get();
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

    public function details($id) 
    {
        $model = Customer::where('id', $id)->first();
        $measurement = Measurement::where('id_customer', $id)->orderBy('measurement_date', 'DESC')->get();
        $gallery = FileMeasurement::where('id_customer', $id)->where('status', 2)->orderBy('created_at', 'DESC')->get();
        return view('cms.customer.details', [
            "data" => $model,
            "measurement" => $measurement,
            "gallery" => $gallery,
        ]);
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

    public function gallery($id)
    {
        $model = Customer::where('id', $id)->first();
        $gallery = FileMeasurement::where('id_customer', $id)->where('status', 2)->orderBy('created_at', 'DESC')->get();
        return view('cms.customer.gallery', [
            "data" => $model,
            "gallery" => $gallery,
        ]);
    }

    public function uploadgallery(Request $request)
    {
        if($request->hasFile('file') && !empty($request->folder))
        {
            list($directory, $id_customer) = explode("/", $request->folder);
            $file = $request->file('file');
            $path = ImageHelper::uploadFile($file, $request->folder);
            $urlFile = env('APP_URL') . Storage::url($path);

            if ($request->savestorage == "true") {
                $increment = (FileMeasurement::where('id_customer', $id_customer)->max('order') == null) ? 0 : FileMeasurement::where('id_customer', $id_customer)->max('order');

                $model = new FileMeasurement;
                $model->id_customer = $id_customer;
                $model->path = $path;
                $model->order = $increment + 1;
                $model->status = 2;
                $model->save();

                return view('cms.customer.layout-gallery', [
                    "item" => $model            
                ]);
            } else {
                return response()->json([
                    'url' => $urlFile
                ], 200);
            }
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $model = Measurement::where('id_customer', $id)->get();
            if (count($model) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data is used',
                ]);
            } else {
                Customer::where([
                    ['id', '=', $id]
                ])->delete();

                $storage = FileMeasurement::where('id_customer', $id)->whereNull('id_measurement')->where('status', 2)->get();
                foreach ($storage as $key => $value) {
                    ImageHelper::removeFilesFromDirectories($value->path);
                    $value->delete();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Data Deleted',
                    'url' => route('customer.index')
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
