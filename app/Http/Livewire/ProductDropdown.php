<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Variation;

class ProductDropdown extends Component
{
    public $variations;
    public $selectedVariation;

    public function getSelectedVariationModelProperty()
    {
        if (! $this->selectedVariation) {
            return;
        }

        return Variation::find($this->selectedVariation);
    }

    public function updatedSelectedVariation()
    {
    }

    public function render()
    {
        return view('livewire.product-dropdown');
    }
}
