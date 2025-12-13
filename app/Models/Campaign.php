<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'type',
        'budget',
        'remaining_budget',
        'start_date',
        'end_date',
        'status'
    ];

    /** المعلن */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** الوسائط */
    public function media()
    {
        return $this->hasMany(CampaignMedia::class);
    }

    /** الفواتير المرتبطة بالحملة */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    /** المهام */
    public function tasks()
    {
        return $this->hasMany(CampaignTask::class);
    }
}
