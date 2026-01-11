<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    protected $fillable = ['unit_id', 'person_id', 'contract_type', 'contract_number', 'ejari_no', 'start_date', 'end_date', 'duration_months', 'total_amount', 'status', 'notes'];
    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];
    
    public function unit() { return $this->belongsTo(Unit::class); }
    public function subunits() { return $this->belongsToMany(Subunit::class, 'contract_subunits'); }
    public function payments() { return $this->hasMany(Payment::class); }
    
    public function person()
    {
        return $this->contract_type === 'owner' 
            ? $this->belongsTo(Owner::class, 'person_id')
            : $this->belongsTo(Tenant::class, 'person_id');
    }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->created_by = auth()->id());
        static::updating(fn($model) => $model->updated_by = auth()->id());
    }
}