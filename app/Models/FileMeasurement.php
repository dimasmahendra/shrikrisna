<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMeasurement extends Model
{
    use HasFactory;

    protected $table = "file_measurement";

    protected $appends = ["url_path"];

    public function getUrlPathAttribute()
    {
        if (empty($this->path)) {
            return url('cms/images/samples/no-image.svg');
        } else {
            if ($this->path == 'no-image.svg') {
                return url('cms/images/samples/no-image.svg');
            } else {
                if(file_exists(storage_path('/app/public/') . $this->path)){
                    return Storage::url($this->path);
                } else {
                    return url('cms/images/samples/no-image.svg');
                }
            }
        }
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'id_customer');
    }

    public function measurement()
    {
        return $this->hasOne(Measurement::class, 'id', 'id_measurement');
    }
}
