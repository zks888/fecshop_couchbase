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

    /**
     * @see ActiveRecord::insert()
     */
    protected function insertInternal($attributes = null)
    {
        if (!$this->beforeSave(true)) {
            return false;
        }

        $values = $this->getDirtyAttributes($attributes);

        if (empty($values)) {
            $currentAttributes = $this->getAttributes();

            if (isset($currentAttributes['_id'])) {
                $values['_id'] = $currentAttributes['_id'];
            }
        }

        $bucket = static::getBucket();
        $sql = $bucket->db->getQueryBuilder()->insert($bucket->name, $values);
        $sql = str_replace('":cart_id"', 'UUID()', $sql);
        $newId = $bucket->db->createCommand($sql)->queryScalar();

        if ($newId !== null) {
            $this->setAttribute('_id', $newId);
            $values['_id'] = $newId;
        }

        $changedAttributes = array_fill_keys(array_keys($values), null);

        $this->setOldAttributes($values);
        $this->afterSave(true, $changedAttributes);

        return true;
    }
}
