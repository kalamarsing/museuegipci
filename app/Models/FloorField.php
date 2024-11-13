<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorField extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['floor_id', 'name', 'value', 'language_id'];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
