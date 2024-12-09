<?php

namespace GIS\Metable\Helpers;

use GIS\Metable\Interfaces\MetaModelInterface;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class MetaActionsManager
{
    public function createDefault(ShouldMetaInterface $model): void
    {
        $metas = $this->getByName($model, "title");
        if (! $metas) {
            $model->metas()->create([
                "name" => "title",
                "content" => $model->title
            ]);
        }

        if (empty($model->short)) return;
        $metas = $this->getByName($model, "description");
        if (! $metas) {
            $model->metas()->create([
                "name" => "description",
                "content" => $model->short
            ]);
        }
    }

    public function clearByModel(ShouldMetaInterface $model): void
    {
        foreach ($model->metas as $meta) {
            $meta->delete();
        }
        $this->forgetByModelCache($model);
    }

    public function getByName(ShouldMetaInterface $model, string $name): ?Collection
    {
        $metas = $model->metas()
            ->select("id", "name", "property", "content")
            ->where("name", $name)
            ->get();
        if (! $metas->count()) return null;
        return $metas;
    }

    public function renderByModel(ShouldMetaInterface $model): array
    {
        $cacheKey = $this->makeCacheKey($model);
        return Cache::rememberForever($cacheKey, function () use ($model) {
            $rendered = [];
            foreach ($model->metas as $meta) {
                $rendered[] = $meta->clear_render;
            }
            return $rendered;
        });
    }

    public function forgetByModelCache(ShouldMetaInterface $model): void
    {
        Cache::forget($this->makeCacheKey($model));
    }

    private function makeCacheKey(ShouldMetaInterface $model): string
    {
        $table = $model->getTable();
        return "meta-model:{$table}-{$model->id}";
    }
}
