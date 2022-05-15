<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductBrowser extends Component
{
    public $category;

    public function render()
    {
        $search = Product::search('', function ($meilisearch, $query, $options) {
            $options['filter'] = 'category_ids = ' . $this->category->id;

            $options['facetsDistribution'] = ['size', 'color']; //refactor

            return $meilisearch->search($query, $options);
        })
            ->raw();

        $products = $this->category->products->find(
            collect($search['hits'])->pluck('id')
        );

        return view('livewire.product-browser', [
            'products' => $products,
            'filters' => $search['facetsDistribution']
        ]);
    }
}
