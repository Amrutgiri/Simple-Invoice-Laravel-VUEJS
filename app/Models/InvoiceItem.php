<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $table = 'invoice_items';

    protected $fillable = ['invoice_id','product_id','unit_price','quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
