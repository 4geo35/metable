<?php

namespace GIS\Metable\Traits;

use GIS\Metable\Interfaces\MetaModelInterface;
use GIS\Metable\Models\Meta;

trait MetaActionsTrait
{
    public bool $displayData = false;
    public int|null $metaId = null;

    public string $name = "";
    public string $content = "";
    public string|null $property = null;
    public bool $separated = false;

    public bool $displayDelete = false;

    public function rules(): array
    {
        return [
            "name" => ["required", "string", "max:50"],
            "content" => ["required", "string"],
            "property" => ["nullable", "string", "max:50"],
        ];
    }

    public function validationAttributes(): array
    {
        return [
            "name" => "Name",
            "content" => "Content",
            "property" => "Property"
        ];
    }

    public function showEdit(int $metaId): void
    {
        $this->resetFields();
        $this->metaId = $metaId;
        // Найти тег
        $meta = $this->findMeta();
        if (! $meta) return;
        // Проверить авторизацию
        $check = $this->checkAuth("update", $meta);
        if (! $check) return;

        $this->name = $meta->name;
        $this->content = $meta->content;
        $this->property = $meta->property;
        $this->separated = $meta->separated ? true : false;

        $this->displayData = true;
    }

    public function update(): void
    {
        // Найти тег
        $meta = $this->findMeta();
        if (! $meta) return;
        // Проверить авторизацию
        $check = $this->checkAuth("update", $meta);
        if (! $check) return;
        // Валидация
        $this->validate();
        $meta->update([
            "name" => $this->name,
            "content" => $this->content,
            "property" => $this->property,
            "separated" => $this->separated ? now() : null,
        ]);

        session()->flash("metas-success", __("Meta tag successfully updated"));
        $this->closeData();
    }

    public function closeData(): void
    {
        $this->resetFields();
        $this->displayData = false;
    }

    public function showDelete(int $metaId): void
    {
        $this->resetFields();
        $this->metaId = $metaId;
        // Найти тег
        $meta = $this->findMeta();
        if (! $meta) return;
        // Проверить авторизацию
        $check = $this->checkAuth("delete", $meta);
        if (! $check) return;

        $this->displayDelete = true;
    }

    public function closeDelete(): void
    {
        $this->displayDelete = false;
        $this->resetFields();
    }

    public function confirmDelete(): void
    {
        // Найти тег
        $meta = $this->findMeta();
        if (! $meta) return;
        // Проверить авторизацию
        $check = $this->checkAuth("delete", $meta);
        if (! $check) return;

        $meta->delete();
        session()->flash("metas-success", __("Meta tag successfully deleted"));

        $this->closeDelete();
    }

    protected function resetFields(): void
    {
        $this->reset(["name", "content", "property", "metaId"]);
    }

    protected function findMeta(): ?MetaModelInterface
    {
        $metaClass = config("metable.customMetaModel") ?? Meta::class;
        $meta = $metaClass::find($this->metaId);
        if (! $meta) {
            session()->flash("metas-error", __("Meta tag not found"));
            $this->closeData();
            return null;
        }
        return $meta;
    }

    protected function checkAuth(string $action, MetaModelInterface $meta = null): bool
    {
        try {
            $this->authorize($action, $meta ?? (config("metable.customMetaModel") ?? Meta::class));
            return true;
        } catch (\Exception $ex) {
            session()->flash("metas-error", __("Unauthorized action"));
            $this->closeData();
            $this->closeDelete();
            return false;
        }
    }
}
