<?php

namespace App\Helpers;

use Exception;
use Thumbnail;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class ImageHelper
{
    public static $dir = 'public';
    public static $parent;
    public static $filename;

    public static function uploadFile($file, $dir = null)
    {
        try {
            $uploadFolder = Self::setDir($dir);
            $filename = Self::createFilename($file);
            $path = $file->storeAs(
                $uploadFolder, $filename, 'public'
            );
            
            $visibility = Storage::getVisibility('public/', $path);
            Storage::setVisibility('public/' . $path, 'public');
            return $path;
        } catch (Exception $e) {
			dd($e->getMessage());
		}
    }

    public static function uploadAndResize($file, $dir = null, $size=1280)
    {
        try {
            $filename = Self::createFilename($file);
            $thumb = Image::make($file)->resize($size, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode($file->extension())->trim('bottom-right');
            
            $name = $dir."/".$filename;
            Storage::disk("public")->put($name, $thumb->__toString());
            return $name;
        } catch (Exception $e) {
			dd($e->getMessage());
		}        
    }

    public static function uploadBase64File($base64_image, $dir = null)
    {        
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $filename = Self::createFilenameBase64($base64_image);
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            
            $image = Image::make($data);
            $image->resize(1280, null, function ($constraint) {
                $constraint->aspectRatio();
            })->encode("png");
            $image->resizeCanvas(1280, null, 'center', false, array(0, 0, 0, 0));
            $thumb = $image->stream();
            
            $data = $thumb->__toString();
            $path = "";
            try {
                $im = imagecreatefromstring($data);
                $path = $dir . "/webpImg".Str::random(20).".webp";
                $ph = imagewebp($im, "storage/".$path);
                if (!$ph) {
                    if ( Storage::disk('local')->put('public/' . $dir . '/'. $filename, $data) ) {
                        $path = $dir . '/' . $filename;
                    } 
                }
            } catch (\Throwable $th) {
                if ( Storage::disk('local')->put('public/' . $dir . '/'. $filename, $data) ) {
                    $path = $dir . '/' . $filename;
                } 
            }

            return $path;
        }
    }

    public static function createImageBackground($file, $dir = null)
    {
        $image = Image::make($file);
        $image->resize(200, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->encode("png");
        $image->resizeCanvas(200, 300, 'center', false, array(0, 0, 0, 0));
        $thumb = $image->stream();
        $data = $thumb->__toString();
        $im = imagecreatefromstring($data);
        $path = $dir . "/qr-logo.png";
        $ph = imagepng($im, "storage/".$path);
        
        if (!$ph) {
            if ( Storage::disk('local')->put('public/' . $dir . '/'. $filename, $data) ) {
                $path = $dir . '/' . $filename;
            } 
        }
        return $path;
    }

    public static function createFilenameBase64($base64_image) 
    {
        $img = preg_replace('/^data:image\/\w+;base64,/', '', $base64_image);
        $type = explode(';', $base64_image)[0];
        $type = explode('/', $type)[1];
        $filename = Str::random() .'-pengaturan.' . $type;
        return $filename;
    }

    public static function createFilename($file) 
    {
        $filename = $file->hashName();
        return $filename;
    }

    public static function setDir($dir = null)
    {
        return (empty($dir)) ? Self::$dir : $dir ;
    }

    public static function removeFilesFromDirectories($file) 
    {
        Storage::delete('public/' . $file);
        return true;
    }

    public static function getInfo($file)
    {
        $img = Image::make($file);
        return [
            'size'         => strlen($img->encoded),
            'width'        => $img->width(),
            'height'       => $img->height(),
            'mime_type'    => $img->mime(),
            'content_type' => $img->mime(),
        ];
    }

    public static function uploadVideoWithTumbnail($file, $dir = null)
    {
        $uploadFolder = Self::setDir($dir);
        $filename = Self::createFilename($file);
        $path = $file->storeAs(
            $uploadFolder, $filename, 'public'
        );
        
        $visibility = Storage::getVisibility('public/', $path);
        Storage::setVisibility('public/' . $path, 'public');

        if(file_exists(storage_path('/app/public/') . $path)){
            $thumb = Self::createThumbnail($path, $dir);
            return (object) ([
                'path' => $path,
                'thumb' => $thumb,
            ]);
        } else {
            echo "Upload Video has failed";
            die();
        }
    }

    public static function createThumbnail($video, $dir)
    {
        $storage_path     = storage_path('app/public'); 
        $thumbnail_image  = pathinfo($video, PATHINFO_FILENAME) . '.jpg';
        $time_to_image    = 1;
        $video_path       = $storage_path . '/' . $video;
        $thumbnail_path   = $storage_path . '/' . $dir . '/thumbnails';
        
        if(!is_dir($thumbnail_path)){
            mkdir($thumbnail_path, 0777, true);
            chmod($thumbnail_path, 0777);
        }
        
        $thumbnail_status = Thumbnail::getThumbnail($video_path, $thumbnail_path, $thumbnail_image, $time_to_image);
        if($thumbnail_status) {
            Storage::setVisibility('public/' . $dir . '/thumbnails/' . $thumbnail_image, 'public');
            return $dir . '/thumbnails/' . $thumbnail_image;
        }
        else {
            echo "Thumbnail Generation has failed";
            die();
        }
    }
}
