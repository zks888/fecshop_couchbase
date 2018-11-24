<?php
namespace fecshop\couchbase\models;

use matrozov\couchbase\ActiveRecord;

class Cart extends ActiveRecord
{
    public function attributes()
    {
        return [
            '_id',
            'cart_id',
            'store',
            'created_at', 
            'updated_at',
            'items_count',
            'customer_id',
            'customer_email',
            'customer_firstname',
            'customer_lastname',
            'customer_is_guest',
            'remote_ip',
            'coupon_code',
            'payment_method',
            'shipping_method',
            'customer_telephone',
            'customer_address_id',
            'customer_address_country',
            'customer_address_state',
            'customer_address_city',
            'customer_address_zip',
            'customer_address_street1',
            'customer_address_street2',
            'app_name',
        ];
    }
}
