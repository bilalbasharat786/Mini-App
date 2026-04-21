<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    // Yeh line add karni hai taake hum title save kar sakein
    protected $fillable = ['title']; 
}
