<?php

namespace GIS\Metable\Models;

use GIS\Metable\Interfaces\MetaModelInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Meta extends Model implements MetaModelInterface
{
    use HasFactory;

    protected $fillable = [
        "name",
        "content",
        "property",
        "meta_id",
        "metable_id",
        "metable_type",
        "page",
        "separated",
    ];

    public function child(): HasOne
    {
        return $this->hasOne(self::class, "meta_id");
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, "meta_id");
    }

    public function metable(): MorphTo
    {
        return $this->morphTo();
    }

    public function getRenderAttribute(): View
    {
        return view("ma::layouts.meta.render", [
            "meta" => $this
        ]);
    }

    public function getClearRenderAttribute(): string
    {
        $str = $this->render->render();
        $str = str_replace("<!--[if BLOCK]><![endif]-->", "", $str);
        $str = str_replace("<!--[if ENDBLOCK]><![endif]-->", "", $str);
        $str = str_replace("\n", "", $str);
        return $str;
    }
}
