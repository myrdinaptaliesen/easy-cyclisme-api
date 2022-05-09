<?php
namespace App\Models;
use App\Models\Competition;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discipline extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_discipline', 
        'image_discipline'
    ]; 

    public function competitions(){
        return $this->hasMany('App\Competition');
    }
    

}