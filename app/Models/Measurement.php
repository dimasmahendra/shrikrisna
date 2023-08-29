<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $table = "measurement";

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 1);
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'id_master_category');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'id_customer');
    }

    public function items()
    {
        return $this->hasMany(CustomerMeasurement::class, 'id_measurement', 'id');
    }

    public function storages()
    {
        return $this->hasMany(FileMeasurement::class, 'id_measurement', 'id');
    }
}
