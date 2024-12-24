<form wire:submit.prevent="store"
      class="flex flex-col space-y-indent-half lg:flex-row lg:space-x-indent-half lg:space-y-0">
    <div class="flex-auto">
        <input type="text" aria-label="{{ __('Page') }}" placeholder="{{ __('Page') }}" required
               class="form-control {{ $errors->has('createPage') }}" wire:model="createPage">
        <x-tt::form.error name="createPage" />
    </div>

    <div class="flex-auto">
        <input type="text" aria-label="Name" placeholder="Name" required
               class="form-control {{ $errors->has('createName') }}" wire:model="createName">
        <x-tt::form.error name="createName" />
    </div>

    <div class="flex-auto">
        <input type="text" aria-label="Content" placeholder="Content" required
               class="form-control {{ $errors->has('createContent') }}" wire:model="createContent">
        <x-tt::form.error name="createContent" />
    </div>

    <div class="flex-auto">
        <input type="text" aria-label="Property" placeholder="Property"
               class="form-control {{ $errors->has('createProperty') }}" wire:model="createProperty">
        <x-tt::form.error name="createProperty" />
    </div>

    <div class="form-check">
        <input type="checkbox"
               class="form-check-input" id="metaCreateSeparated"
               wire:model="createSeparated">
        <label for="metaCreateSeparated" class="form-check-label text-nowrap">
            {{ __("Don't create og") }}
        </label>
    </div>

    <button type="submit" class="btn btn-primary">{{ __("Add") }}</button>
</form>
