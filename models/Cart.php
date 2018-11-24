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

    /**
     * 给model对应的bucket创建索引的方法
     * 在migrate的时候会运行创建索引，譬如：
     * @fecshop/couchbase/migrations/m181124_224655_cart_buckets
     */
    public static function create_index()
    {
        $sql = 'CREATE PRIMARY INDEX `idx_id` ON `cart`;';
        self::getDb()->createCommand($sql)->execute();
        $sql = 'CREATE INDEX `idx_cartid` ON `cart`(`cart_id`);';
        self::getDb()->createCommand($sql)->execute();
    }
}
