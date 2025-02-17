<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Product extends Model
{
    use HasFactory , HasRoles ;

    protected $fillable = ['name', 'code','description', 'price', 'images'];

    protected $casts = [
        'images' => 'array', // Automatically cast images JSON to array
    ];


    public function isActive()
    {
        return $this->status === 'Y';
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->code = generateProductCode();
        });
    }

    
}
