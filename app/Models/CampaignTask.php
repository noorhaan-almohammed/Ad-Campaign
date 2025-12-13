<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignTask extends Model
{
     protected $fillable = [
        'campaign_id',
        'title',
        'description',
        'reward',
        'max_completions',
        'status'
    ];

    /** الحملة */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /** مهام الناشر */
    public function publisherTasks()
    {
        return $this->hasMany(PublisherTask::class, 'task_id');
    }
}
