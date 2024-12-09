<?php

namespace GIS\Metable\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface ShouldMetaInterface
{
    public function getMetaClassAttribute(): string;
    public function metas(): MorphMany;
}
