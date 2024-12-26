<?php

namespace GIS\Metable\Facades;

use GIS\Metable\Helpers\MetaActionsManager;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Facade;

/**
 * @method static void createDefault(ShouldMetaInterface $model)
 * @method static void clearByModel(ShouldMetaInterface $model)
 * @method static Collection|null getByName(ShouldMetaInterface $model, string $name)
 * @method static array renderByModel(ShouldMetaInterface $model)
 * @method static void forgetByModelCache(ShouldMetaInterface $model)
 * @method static array renderByPage(string $page)
 * @method static void forgetByPageCache(string $page)
 *
 * @see MetaActionsManager
 */
class MetaActions extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return "meta-actions";
    }
}
