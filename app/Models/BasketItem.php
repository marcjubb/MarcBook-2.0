<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// BasketItem model
class BasketItem extends Model
{
    protected $fillable = ['product_id','user_id','quantity'];
    use  HasFactory;
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}





