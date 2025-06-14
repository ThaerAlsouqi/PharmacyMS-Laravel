<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DemandPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'drug_name',
        'recent_sales',
        'predicted_demand',
        'suggested_order',
        'confidence',
        'model_info'
    ];

    protected $casts = [
        'recent_sales' => 'array',
        'model_info' => 'array',
        'predicted_demand' => 'decimal:2',
        'suggested_order' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('M j, Y g:i A');
    }

    public function getConfidenceBadgeClassAttribute()
    {
        switch ($this->confidence) {
            case 'high':
                return 'badge-success';
            case 'medium':
                return 'badge-warning';
            case 'low':
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeByDrug($query, $drugName)
    {
        return $query->where('drug_name', 'LIKE', '%' . $drugName . '%');
    }
}