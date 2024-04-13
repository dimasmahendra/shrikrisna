<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = "customer";

    protected $appends = ["image_url", "first_letter"];

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

    public function getFirstLetterAttribute()
    {
        $str = mb_substr(ucfirst($this->name), 0, 1);
        if ($this->created_at == null) {
            $str = mb_substr(ucfirst($this->name), 0, 1);
        } else {
            $created_at = $this->created_at->format('Y-m-d H:i:s');
            $lastsevendays = Carbon::now()->subDays(7)->format('Y-m-d') . " 00:00:00";
            if ($created_at >= $lastsevendays) {
                $str = "New Customer";
            }
        } 
        return $str;
    }
}
