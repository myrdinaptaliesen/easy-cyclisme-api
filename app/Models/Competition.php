<?php
namespace App\Models;
use App\Models\Discipline;
use App\Models\Cyclists_Category;
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

    public function cyclistsCategories(){
        return $this->belongsToMany(Cyclists_Category::class)->withTimestamps();
    }

}