<?php

namespace App\Http\Controllers\Cms;

use Carbon\Carbon;
use App\Models\Customer;
use App\Helpers\ImageHelper;
use App\Models\Measurement;
use App\Models\CustomerMeasurement;
use App\Models\FileMeasurement;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public $maxrow = 15;

    public function index(Request $request)
    {
        $count = Customer::count();
        return view('cms.customer.index', [
            "total" => $count,
            "maxrow" => $this->maxrow,
            "maxcount" => ceil($count / $this->maxrow),
        ]);
    }

    public function dt(Request $request)
    {
        $page = ($request->pageNumber == null) ? 1 : $request->pageNumber;
        $take = $this->maxrow;
        $offset = $take * ($page - 1);
        $lastsevendays = Carbon::now()->subDays(7)->format('Y-m-d') . " 00:00:00";

        $model = Customer::select('id', 'name', 'nomor_ktp', 'phone_number', 'institution', 'created_at')
                    ->skip($offset)->take($take)
                    ->orderByRaw("(CASE WHEN created_at >= '" . $lastsevendays . "' THEN 0 ELSE 1 END) ASC, name ASC");

        if ($request->search != null) {
            $search = $request->search;
            $model->where(function($q) use ($search) {
                $q->where('name','ILIKE','%'.$search.'%')
                    ->orWhere('nomor_ktp','ILIKE','%'.$search.'%')
                    ->orWhere('phone_number','ILIKE','%'.$search.'%')
                    ->orWhere('institution','ILIKE','%'.$search.'%');
            });
        }

        $result = $model->get();

        return [
            "result" => $result
        ];
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
                $path_photo = ImageHelper::uploadBase64File($request->file_compressed, 'customer');
                $model->photo = $path_photo;
            } else {
                $model->photo = "no-image.svg";
            }

            $model->nomor_ktp = $request->nomor_ktp;
            $model->name = $request->name;
            $model->email = $request->email;
            $model->phone_number = $request->phone_number;
            $model->institution = $request->institution;
            $model->address = $request->address;
            $model->notes = $request->notes;
            $model->created_at = date("Y-m-d H:i:s");
            $model->save();

            DB::commit();

            return redirect(route('category.measurement.create', [$model->id]))->with("message", "Saved");

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function details($id)
    {
        $model = Customer::where('id', $id)->first();
        $measurement = Measurement::where('id_customer', $id)
                        ->orderBy('measurement_date', 'DESC')
                        ->orderBy('created_at', 'DESC')
                        ->get();
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
                $path_photo = ImageHelper::uploadBase64File($request->file_compressed, 'customer');
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
                $increment = (FileMeasurement::where('id_customer', $id_customer)->max('order') == null) ?
                0 : FileMeasurement::where('id_customer', $id_customer)->max('order');

                $model = new FileMeasurement;
                $model->id_customer = $id_customer;
                $model->path = $path;
                $model->order = $increment + 1;
                $model->status = 2;
                $model->save();

                return view('cms.customer.layout-gallery', [
                    "item" => $model,
                    "directory" => $directory
                ]);
            } else {
                return response()->json([
                    'url' => $urlFile
                ], 200);
            }
        }
    }

    public function destroyGallery(Request $request, $id, $id_customer)
    {
        try {
            $storage = FileMeasurement::where('id', $id)->first();
            ImageHelper::removeFilesFromDirectories($storage->path);
            $storage->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data Deleted',
                'url' => route('customer.gallery', [$id_customer])
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {

            $measurement = Measurement::where('id_customer', $id)->first();
            if (!empty($measurement)) {

                CustomerMeasurement::where('id_measurement', $measurement->id)->delete();
                $measurement->delete();

                $storage = FileMeasurement::where('id_customer', $id)
                                ->whereNull('id_measurement')
                                ->where('status', 2)
                                ->get();

                foreach ($storage as $value) {
                    ImageHelper::removeFilesFromDirectories($value->path);
                    $value->delete();
                }
            }

            Customer::where([
                ['id', '=', $id]
            ])->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data Deleted',
                'url' => route('customer.index')
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
