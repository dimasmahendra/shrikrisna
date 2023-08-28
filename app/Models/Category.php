<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = "master_category";

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function details()
    {
        return $this->hasMany(CategoryDetails::class, 'id_master_category', 'id')->orderBy('order', 'ASC');
    }
}
