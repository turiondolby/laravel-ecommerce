<div class="mt-3">
    <div class="font-semibold mb-1">
        {{ Str::title(optional($variations->first())->type) }}
    </div>

    {{ $selectedVariation }}

    <x-select wire:model="selectedVariation" class="w-full">
        <option value="">Choose an option</option>

        @foreach ($variations as $variation)
            <option value="{{ $variation->id }}">
                {{ $variation->title }}
            </option>
        @endforeach
    </x-select>
</div>
