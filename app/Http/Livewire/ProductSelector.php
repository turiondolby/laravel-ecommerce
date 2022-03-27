<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Variation;

class ProductSelector extends Component
{
    public $product;
    public $initialVariation;
    public $skuVariant;

    protected $listeners = [
        'skuVariantSelected'
    ];

    public function mount()
    {
        $this->initialVariation = $this->product->variations->sortBy('order')->groupBy('type')->first();
    }

    public function skuVariantSelected($variantId)
    {
        if (! $variantId) {
            $this->skuVariant = null;
            return;
        }

        $this->skuVariant = Variation::find($variantId);
    }

    public function addToCart()
    {
        dd($this->skuVariant);
    }

    public function render()
    {
        return view('livewire.product-selector');
    }
}
