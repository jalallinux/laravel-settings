<?php

namespace JalalLinuX\Settings\Setting;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = ['updated_at', 'id'];

    protected $table = 'settings';

    public function scopeGroup(Builder $query, $groupName): Builder
    {
        return $query->where('group', $groupName);
    }
}
