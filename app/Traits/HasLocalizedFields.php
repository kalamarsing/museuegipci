<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait HasLocalizedFields
{
    /**
     * Obtiene los campos organizados por nombre.
     *
     * @return array
     */
    public function getLocalizedFields()
    {
        return $this->fields->groupBy('name')->map(function ($items) {
            $result = [];
            foreach ($items as $item) {
                if ($item->language_id) {
                    $result[$item->language_id] = $item->value;
                } else {
                    $result['default'] = $item->value;
                }
            }
            return $result;
        })->toArray();
    }
}
