<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subunit extends Model
{
    use SoftDeletes;
    protected $fillable = ['unit_id', 'subunit_no', 'subunit_type', 'area_sqft', 'status'];
    
    public function unit() { return $this->belongsTo(Unit::class); }
    public function contracts() { return $this->belongsToMany(Contract::class, 'contract_subunits'); }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->created_by = auth()->id());
        static::updating(fn($model) => $model->updated_by = auth()->id());
    }
}