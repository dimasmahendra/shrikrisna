<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    protected $appends = ["image_url"];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getImageUrlAttribute()
    {
        if (empty($this->photo)) {
            return url('cms/images/samples/no_user_60.png');
        } else {
            if(file_exists(storage_path('/app/public/') . $this->photo)){
                return Storage::url($this->photo);
            } else {
                return url('cms/images/samples/no_user_60.png');
            }
        }
    }
}
