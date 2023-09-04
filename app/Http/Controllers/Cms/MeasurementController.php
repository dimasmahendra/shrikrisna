<?php

namespace App\Http\Controllers\Cms;

use PDF;
use Config;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Customer;
use App\Models\Category;
use App\Models\FileMeasurement;
use App\Models\Measurement;
use App\Models\CustomerMeasurement;

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
            "storage" => array(),
        ]);
    }

    public function store(Request $request, $id) 
    {
        try {

            DB::beginTransaction();

            $model = new Measurement;
            $model->id_customer = $id;
            $model->id_master_category = $request->id_category;
            $model->measurement_date = Carbon::createFromFormat('Y-m-d', date("Y-m-d", strtotime($request->measurement_date)))
                                        ->timezone(Config::get('app.timezone'))->format('Y-m-d');
            $model->status = 1;
            $model->save();

            foreach ($request->details as $key => $item) {
                foreach ($item['value'] as $i => $value) {
                    $detail = new CustomerMeasurement;
                    $detail->id_measurement = $model->id;
                    $detail->id_master_category_details = $key;
                    $detail->value = $value;
                    $detail->option = $item['option'][$i];
                    $detail->save();
                }
            }

            if ($request->storageid != null) {
                foreach ($request->storageid as $k => $id_storage) {
                    FileMeasurement::where('id', $id_storage)->
                            where('id_customer', $id)->update(['id_measurement' => $model->id]);
                }
            }

            DB::commit();

            return redirect(route('customer.details', [$id]))->with("message", "Saved");

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function details($id) 
    {
        $model = Measurement::where('id', $id)->first();
        return view('cms.measurement.details', [
            "data" => $model
        ]);
    }

    public function print(Request $request, $id) 
    {
        // return view('cms.measurement.pdf', [
        //     "data" => $request->ids_measurement
        // ]);

        $pdf = PDF::loadView('cms.measurement.pdf', [
                        "data" => $request->ids_measurement,
                        "id" => $id
                    ]);
        $pdf->setPaper('A4', 'portrait');

        // return $pdf->stream();
        return $pdf->download();
    }
}
