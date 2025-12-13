<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignMedia extends Model
{
    protected $fillable = [
        'campaign_id',
        'file_path',
        'url',
        'type',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
