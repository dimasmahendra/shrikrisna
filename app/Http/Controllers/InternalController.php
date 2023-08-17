<?php

namespace App\Http\Controllers;

use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Storages;

class InternalController extends Controller
{
    public function uploadImage(Request $request)
    {
        if($request->hasFile('image') && !empty($request->folder))
        {
            $images = $request->file('image');
            $path = ImageHelper::uploadFile($images, $request->folder);
            $urlImage = env('APP_URL') . Storage::url($path);

            if ($request->savestorage == "true") {
                $lastinsertedid = Storages::storedToDb($path, $request->folder);
                return response()->json([
                    'url' => $urlImage,
                    'last_insert_id' => $lastinsertedid,
                ], 200);
            } else {
                return response()->json([
                    'url' => $urlImage
                ], 200);
            }
        }
    }

    public function deleteImage($id)
    {
        $storages = Storages::find($id);
        ImageHelper::removeFilesFromDirectories($storages->path);
        $storages->delete();
        return response()->json([
            'id' => $id,
        ], 200);
    }
}
