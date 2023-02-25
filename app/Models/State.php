<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function regionstates()
    {
        return $this->hasMany(Regionstate::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }

    public function pastors()
    {
        return $this->hasMany(Pastor::class);
    }
}
