<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use SoftDeletes;
    protected $fillable = ['building_id', 'unit_no', 'floor_no', 'area_sqft', 'assets', 'status'];
    protected $casts = ['assets' => 'array'];
    
    public function building() { return $this->belongsTo(Building::class); }
    public function subunits() { return $this->hasMany(Subunit::class); }
    public function contracts() { return $this->hasMany(Contract::class); }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->created_by = auth()->id());
        static::updating(fn($model) => $model->updated_by = auth()->id());
    }
}