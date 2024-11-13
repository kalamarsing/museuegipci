<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElementField extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['element_id', 'name', 'value', 'language_id'];

    public function element()
    {
        return $this->belongsTo(Element::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
