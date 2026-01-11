<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $fillable = ['contract_id', 'payment_type', 'payment_number', 'bank_name', 'amount', 'due_date', 'status', 'notes'];
    protected $casts = ['due_date' => 'date'];
    
    public function contract() { return $this->belongsTo(Contract::class); }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->created_by = auth()->id());
        static::updating(fn($model) => $model->updated_by = auth()->id());
    }
}