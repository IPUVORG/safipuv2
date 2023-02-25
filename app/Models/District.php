<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function sectors()
    {
        return $this->hasMany(Sector::class);
    }

    public function pastors()
    {
        return $this->hasMany(Pastor::class);
    }
}
