<?php

namespace App\Http\Controllers\Cms;

use PDF;
use Config;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Helpers\ImageHelper;
use App\Models\Customer;
use App\Models\Category;
use App\Models\CategoryDetails;
use App\Models\FileMeasurement;
use App\Models\Measurement;
use App\Models\CustomerMeasurement;

class MeasurementController extends Controller
{
    public function category($id)
    {
        // $model = Category::select("id")->where('id', $id)->active()->first();
        $model = CategoryDetails::where('id_master_category', $id)->orderBy('order', 'ASC')->get();
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

            $model = new Measurement;
            $model->id_customer = $id;
            $model->id_master_category = $request->id_category;
            $model->measurement_date = Carbon::createFromFormat('Y-m-d', date("Y-m-d", strtotime($request->measurement_date)))
                                        ->timezone(Config::get('app.timezone'))->format('Y-m-d');
            $model->notes = $request->notes;
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
                FileMeasurement::where('id_customer', $id)
                            ->whereIn('id', $request->storageid)
                            ->update(['id_measurement' => $model->id]);
            }

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

    public function edit($id) 
    {
        $model = Measurement::where('id', $id)->first();
        $storage = FileMeasurement::where('id_measurement', $id)->get();
        return view('cms.measurement.edit', [
            "data" => $model,
            "storage" => $storage,
        ]);
    }

    public function update(Request $request, $id) 
    {
        try {

            DB::beginTransaction();

            $model = Measurement::where('id', $id)->first();
            $model->measurement_date = Carbon::createFromFormat('Y-m-d', date("Y-m-d"))
                                        ->timezone(Config::get('app.timezone'))->format('Y-m-d');
            $model->updated_at = Carbon::createFromFormat('Y-m-d', date("Y-m-d"))
                                        ->timezone(Config::get('app.timezone'))->format('Y-m-d');
            $model->notes = $request->notes;
            $model->save();

            foreach ($request->details as $key => $item) {
                foreach ($item['value'] as $i => $value) {
                    $detail = CustomerMeasurement::where('id', $key)->first();
                    $detail->value = $value;
                    $detail->option = $item['option'][$i];
                    $detail->save();
                }
            }

            if (isset($request->newdetails) && count($request->newdetails) > 0) {
                foreach ($request->newdetails as $key => $item) {
                    foreach ($item['value'] as $i => $value) {
                        $detail = new CustomerMeasurement;
                        $detail->id_measurement = $model->id;
                        $detail->id_master_category_details = $key;
                        $detail->value = $value;
                        $detail->option = $item['option'][$i];
                        $detail->save();
                    }
                }
            }

            if ($request->storageid != null) {
                FileMeasurement::where('id_customer', $model->id_customer)
                            ->whereIn('id', $request->storageid)
                            ->update(['id_measurement' => $id]);
            }

            DB::commit();

            return redirect(route('customer.details', [$model->id_customer]))->with("message", "Saved");

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }

    public function print(Request $request, $id) 
    {
        ini_set("memory_limit", "-1");
        
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

    public function destroy(Request $request, $id)
    {
        try {
            CustomerMeasurement::where([
                ['id_measurement', '=', $id]
            ])->delete();

            $storage = FileMeasurement::where('id_measurement', $id)->where('status', 1)->get();
            foreach ($storage as $key => $value) {
                ImageHelper::removeFilesFromDirectories($value->path);
                $value->delete();
            }

            $find = Measurement::where([
                ['id', '=', $id]
            ])->first();
            $find->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data Deleted',
                'url' => route('customer.details', [$find->id_customer])
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
