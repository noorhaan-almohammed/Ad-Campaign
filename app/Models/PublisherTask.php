<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublisherTask extends Model
{
    protected $fillable = [
        'publisher_id',
        'campaign_id',
        'campaign_task_id',
        'status',
        'reward',
        'proof',
    ];

    /**
     * الناشر
     */
    public function publisher()
    {
        return $this->belongsTo(User::class, 'publisher_id');
    }

    /**
     * الحملة
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * المهمة الأساسية داخل الحملة (مثل CPA task / Screenshot task ...)
     */
    public function task()
    {
        return $this->belongsTo(CampaignTask::class, 'campaign_task_id');
    }
}
