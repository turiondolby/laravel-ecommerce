<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-2 gap-4">
                    <div class="col-span-1 grid">
                        Image gallery
                    </div>
                    <div class="col-span-1 p-6 space-y-6">
                        <div>
                            <h1>{{ $product->title }}</h1>
                            <h1 class="font-semibold text-xl mt-2">
                                {{ $product->formattedPrice() }}
                            </h1>
                            <p class="mt-2 text-gray-500">
                                {{ $product->description }}
                            </p>
                        </div>

                        <div class="mt-6">
                            <livewire:product-selector :product="$product" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
