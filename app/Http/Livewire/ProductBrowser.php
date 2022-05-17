<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductBrowser extends Component
{
    public $category;

    public $queryFilters = [];

    public function mount()
    {
        $this->queryFilters = $this->category->products->pluck('variations')
            ->flatten()
            ->groupBy('type')
            ->keys()
            ->mapWithKeys(function ($key) {
                return [$key => []];
            })
            ->toArray();
    }

    public function render()
    {
        $search = Product::search('', function ($meilisearch, $query, $options) {
            $filters = collect($this->queryFilters)
                ->filter()
                ->recursive()
                ->map(function ($value, $key) {
                    return $value->map(function ($value) use ($key) {
                        return $key . ' = "' . $value . '"';
                    });
                })
                ->flatten()
                ->join(' AND ');

            $options['facetsDistribution'] = ['size', 'color']; //refactor

            if ($filters) {
                $options['filter'] = $filters;
            }

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
