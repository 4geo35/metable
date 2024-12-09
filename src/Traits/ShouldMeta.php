<?php

namespace GIS\Metable\Traits;

use GIS\Metable\Facades\MetaActions;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use GIS\Metable\Models\Meta;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait ShouldMeta
{
    protected static function bootShouldMeta(): void
    {
        static::created(function (ShouldMetaInterface $model) {
            MetaActions::createDefault($model);
        });

        static::deleting(function (ShouldMetaInterface $model) {
            MetaActions::clearByModel($model);
        });
    }

    public function getMetaClassAttribute(): string
    {
        return config("metable.customMetaModel") ?? Meta::class;
    }

    public function metas(): MorphMany
    {
        return $this->morphMany($this->meta_class, "metable");
    }
}
