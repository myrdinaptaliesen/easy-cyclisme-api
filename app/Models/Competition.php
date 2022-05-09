<?php
namespace App\Models;
use App\Models\Discipline;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Competition extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_competition', 
        'date_competition',
        'address_competition', 
        'postal_code_competition', 
        'city_competition', 
        'lat_competition', 
        'lon_competition', 
        'organizational_details',
        'club_id',
        'discipline_id' 
    ];
    
    public function club(){
        return $this->belongsTo('App\Club');
    }

    public function disicpline(){
        return $this->belongsTo('App\Discipline');
    }

}