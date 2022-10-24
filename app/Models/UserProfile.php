<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'full_name', 'handphone_number','address'];
    protected $hidden = ['user_id'];
    public function user(){
        return $this->belongsTo(User::class, 'id');
    }
}
