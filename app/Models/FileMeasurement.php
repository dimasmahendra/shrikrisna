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
            return Storage::url($this->path);
        }
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
