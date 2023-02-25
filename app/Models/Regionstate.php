<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regionstate extends Model
{
    use HasFactory;

    protected $fillable = ['region_id', 'name'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function pastors()
    {
        return $this->hasMany(Pastor::class);
    }
}
