<?php

namespace GIS\Metable\Livewire\Admin\Metas;

use GIS\Metable\Interfaces\MetaModelInterface;
use GIS\Metable\Interfaces\ShouldMetaInterface;
use GIS\Metable\Models\Meta;
use GIS\Metable\Traits\MetaActionsTrait;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class IndexWire extends Component
{
    use MetaActionsTrait;

    public ShouldMetaInterface $model;

    public function render(): View
    {
        $metaClass = config("metable.customMetaModel") ?? Meta::class;
        $metas = $metaClass::query()
            ->select("id", "name", "content", "property", "separated")
            ->where("metable_id", $this->model->id)
            ->where("metable_type", $this->model::class)
            ->orderBy("name")
            ->get();
        return view('ma::livewire.admin.metas.index-wire', compact("metas"));
    }

    public function showCreate(): void
    {
        $this->resetFields();
        $this->displayData = true;
    }

    public function store(): void
    {
        // Валидация
        $this->validate();
        $this->model->metas()->create([
            "name" => $this->name,
            "content" => $this->content,
            "property" => $this->property,
            "separated" => $this->separated ? now() : null,
        ]);

        session()->flash("metas-success", __("Meta tag successfully added"));
        $this->closeData();
    }
}
