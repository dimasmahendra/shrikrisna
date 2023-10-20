<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\FileMeasurement;

class InternalController extends Controller
{
    public function uploadImage(Request $request)
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
                $model->status = 1;
                $model->save();

                return response()->json([
                    'url' => $urlFile,
                    'last_insert_id' => $model->id,
                ], 200);
            } else {
                return response()->json([
                    'url' => $urlFile
                ], 200);
            }
        }
    }

    public function deleteImage($id)
    {
        $storages = FileMeasurement::find($id);
        ImageHelper::removeFilesFromDirectories($storages->path);
        $storages->forceDelete();
        return response()->json([
            'id' => $id,
        ], 200);
    }
}
