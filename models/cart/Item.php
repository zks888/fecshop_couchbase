<?php
namespace fecshop\couchbase\models\cart;

use matrozov\couchbase\ActiveRecord;

class Item extends ActiveRecord
{
    public function attributes()
    {
        return [
            '_id',
            'item_id', 
            'store',
            'cart_id', 
            'created_at',
            'updated_at',
            'product_id',
            'qty',
            'active',
            'custom_option_sku',
        ];
    }
}
