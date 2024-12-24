<?php

return [
    "customMetaIndexComponent" => null,
    "customMetaModel" => null,
    "customMetaObserver" => null,
    "customMetaPageComponent" => null,
    "ogMetas" => [
        "title",
        "type",
        "url",
        "image",
        "description"
    ],
    // Policy
    "metaPolicyTitle" => "Управление мета тегами",
    "metaPolicy" => \GIS\Metable\Policies\MetaPolicy::class,
    "metaPolicyKey" => "metas",
];
