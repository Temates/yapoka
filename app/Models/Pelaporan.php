<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function scopeFilter($query, array $filters)
    {
        // if(isset($filters['search']) ? $filters['search'] : false) {
        //     return $query->where('title','like', '%' . $filters['search'] . '%')
        //             ->orWhere('body','like', '%' . $filters['search'] . '%');
            

        // }

        $query->when($filters['search'] ?? false, function($query, $search){
                    return $query->where('title','like', '%' . $search . '%')
                    ->orWhere('body','like', '%' . $search . '%');

        });
        
        
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function author(){
        return $this->belongsTo(User::class, 'id');
    }
}
