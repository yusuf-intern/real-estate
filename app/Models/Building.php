<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Building extends Model
{
    use SoftDeletes;
    protected $fillable = ['owner_id', 'building_name', 'address', 'city', 'status'];
    
    public function owner() { return $this->belongsTo(Owner::class); }
    public function units() { return $this->hasMany(Unit::class); }
    
    protected static function boot()
    {
        parent::boot();
        static::creating(fn($model) => $model->created_by = auth()->id());
        static::updating(fn($model) => $model->updated_by = auth()->id());
    }
}