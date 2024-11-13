<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasLocalizedFields;

class Floor extends Model
{

    protected $fieldModel = 'App\Models\FloorField';

    use HasFields, SoftDeletes, HasLocalizedFields;

    protected $fillable = ['map', 'map2', 'image', 'order'];

    public function elements()
    {
        return $this->hasMany(Element::class);
    }
}
