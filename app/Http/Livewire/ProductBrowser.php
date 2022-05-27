<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductBrowser extends Component
{
    public $category;

    public $queryFilters = [];

    public $priceRage = [
        'max' => null
    ];

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
                ->join(' OR ');

            $options['facetsDistribution'] = ['size', 'color']; //refactor

            $options['filter'] = null;

            if ($filters) {
                $options['filter'] = $filters;
            }

            if ($this->priceRage['max']) {
                $options['filter'] .= (isset($options['filter']) ? ' AND ' : '') . 'price <= ' . $this->priceRage['max'];
            }

            return $meilisearch->search($query, $options);
        })
            ->raw();

        $products = $this->category->products->find(
            collect($search['hits'])->pluck('id')
        );

        $maxPrice = $this->category->products->max('price');

        $this->priceRage['max'] = $this->priceRage['max'] ?: $maxPrice;

        return view('livewire.product-browser', [
            'products' => $products,
            'filters' => $search['facetsDistribution'],
            'maxPrice' => $maxPrice
        ]);
    }
}
