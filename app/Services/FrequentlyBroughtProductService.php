<?php

namespace App\Services;

use App\Models\FrequentlyBroughtProduct;
use DB;

class FrequentlyBroughtProductService
{
    public function store(array $data)
    {
        $collection = collect($data);
        
        if(isset($collection['fq_brought_product_ids']) && 
            $collection['fq_brought_product_ids'] != null && 
                $collection['frequently_brought_selection_type'] == 'product' ){
            foreach($collection['fq_brought_product_ids'] as $fq_product){

                FrequentlyBroughtProduct::insert([
                    'product_id' => $collection['product_id'],
                    'frequently_brought_product_id' => $fq_product,
                ]);
            }
        }
        elseif(isset($collection['fq_brought_product_category_id']) && 
                $collection['fq_brought_product_category_id'] != null && 
                    $collection['frequently_brought_selection_type'] == 'category') {
            FrequentlyBroughtProduct::insert([
                'product_id' => $collection['product_id'],
                'category_id' => $collection['fq_brought_product_category_id'],
            ]);
        }
        
    }

    public function product_duplicate_store($frequently_brought_products, $product_new)
    {
        foreach ($frequently_brought_products as $fqb_product) {
            FrequentlyBroughtProduct::insert([
                'product_id' => $product_new->id,
                'frequently_brought_product_id' => $fqb_product->frequently_brought_product_id,
                'category_id' => $fqb_product->category_id,
            ]);
        }
    }
}