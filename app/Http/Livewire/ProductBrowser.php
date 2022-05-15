<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductBrowser extends Component
{
    public $category;

    public function render()
    {
        $products = Product::search('', function ($meilisearch, $query, $options) {
            $options['filter'] = 'category_ids = ' . $this->category->id;

            return $meilisearch->search($query);
        })->get();

        return view('livewire.product-browser', [
            'products' => $products
        ]);
    }
}
