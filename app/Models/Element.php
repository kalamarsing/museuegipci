<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasLocalizedFields;

class Element extends Model
{
    protected $fieldModel = 'App\Models\ElementField';

    use HasFields, SoftDeletes, HasLocalizedFields;

    protected $fillable = ['floor_id', 'latitude', 'longitude', 'permanent_exposition', 'number', 'audio_image', 'video_image'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }
}