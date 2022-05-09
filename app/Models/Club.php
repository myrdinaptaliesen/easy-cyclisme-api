<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_club', 
        'logo_club'
    ]; 
    
    public function competitions(){
        return $this->hasMany('App\Competition');
    }
}