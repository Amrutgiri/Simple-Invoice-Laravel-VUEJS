<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\InvoiceItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $table = "invoices";

    protected $fillable = ['number','customer_id','date','due_date','reference','terms_and_conditions','sub_total','discount','total'];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
