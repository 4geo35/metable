<?php

namespace GIS\Metable\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Contracts\View\View;

interface MetaModelInterface
{
    public function child(): HasOne;
    public function parent(): BelongsTo;
    public function metable(): MorphTo;
    public function getRenderAttribute(): View;
    public function getClearRenderAttribute(): string;
}
