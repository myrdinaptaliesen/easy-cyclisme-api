<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];    
}