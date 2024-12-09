<?php

namespace GIS\Metable\Observers;

use GIS\Metable\Facades\MetaActions;
use GIS\Metable\Interfaces\MetaModelInterface;
use GIS\Metable\Models\Meta;
use Illuminate\Database\Eloquent\Model;

class MetaObserver
{
    public function created(Model $meta): void
    {
        if (
            in_array($meta->name, config("metable.ogMetas")) &&
            empty($meta->property) &&
            empty($meta->separated)
        ) {
            $data = $meta->toArray();
            $data["property"] = "og:{$meta->name}";
            $data["meta_id"] = $meta->id;
            $metaModel = config("metable.customMetaModel") ?? Meta::class;
            $metaModel::create($data);
            MetaActions::forgetByModelCache($meta->metable);
        }
    }

    public function updated(MetaModelInterface $meta): void
    {
        $child = $meta->child;
        if (! empty($child) && empty($child->separated)) {
            /**
             * @var Model $child
             */
            $data = $meta->toArray();
            $data["meta_id"] = $meta->id;
            $data["property"] = $child->property;
            $child->update($data);
        }
        MetaActions::forgetByModelCache($meta->metable);
    }

    public function deleted(MetaModelInterface $meta)
    {
        $child = $meta->child;
        if (! empty($child)) $child->delete();
        MetaActions::forgetByModelCache($meta->metable);
    }
}
