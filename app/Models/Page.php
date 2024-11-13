<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFields;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasLocalizedFields;

class Page extends Model
{
    protected $fieldModel = 'App\Models\PageField';

    use HasFields, SoftDeletes, HasLocalizedFields;

    protected $fillable = ['identifier', 'type'];
}