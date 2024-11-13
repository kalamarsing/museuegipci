<?php

namespace App\Traits;

use Carbon\Carbon;


trait ConvertCreatedAndUpdatedDateToTimestamps
{

    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->timestamp * 1000;
    }

    public function getUpdatedAtAttribute($value)
    {
        return (new Carbon($value))->timestamp * 1000;
    }


}
