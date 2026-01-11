<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    public $timestamps = false;
    protected $fillable = ['user_id', 'action', 'model_type', 'model_id', 'old_data', 'new_data', 'created_at'];
    protected $casts = ['old_data' => 'array', 'new_data' => 'array', 'created_at' => 'datetime'];
}