<div class="mt-3">
    <div class="font-semibold mb-1">
        {{ Str::title(optional($variations->first())->type) }}
    </div>

    <x-select wire:model="selectedVariation" class="w-full">
        <option value="">Choose an option</option>

        @foreach ($variations as $variation)
            <option value="{{ $variation->id }}" {{ $variation->outOfStock() ? 'disabled' : '' }}>
                {{ $variation->title }} {{ $variation->lowStock() ? '(Low stock)' : '' }} {{ $variation->outOfStock() ? '(Out of stock)' : '' }}
            </option>
        @endforeach
    </x-select>

    @if (optional(optional($this->selectedVariationModel)->children)->count())
        <livewire:product-dropdown :variations="$this->selectedVariationModel->children->sortBy('order')" :key="$selectedVariation" />
    @endif
</div>
