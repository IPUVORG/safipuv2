<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pastor extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_id',
        'district_id',
        'sector_id',
        'state_id',
        'city_id',
        'name',
        'lastname',
        'genre_id',
        'nationality_id',
        'cardNumber',
        'birthdate',
        'placedate',
        'marital_id',
        'blood_id',
        'study_id',
        'school',
        'baptismdate',
        'baptizerman',
        'phonehome',
        'phonemovil',
        'email',
        'addresspastor',
        'house_id',
        'ivss',
        'lph',
        'otherwork',
        'work',
        'rifNumber',
        'startdate',
        'profile_photo_path'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function nationality()
    {
        return $this->belongsTo(Nationality::class);
    }

    public function marital()
    {
        return $this->belongsTo(Marital::class);
    }

    public function blood()
    {
        return $this->belongsTo(Blood::class);
    }

    public function study()
    {
        return $this->belongsTo(Study::class);
    }

    public function house()
    {
        return $this->belongsTo(House::class);
    }

}
