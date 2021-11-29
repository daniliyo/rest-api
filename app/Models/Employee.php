<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['firstname', 'lastname', 'patronymic', 'gender', 'salary'];

    public function departments(){
    	return $this->belongsToMany(Department::class);
    }
}
