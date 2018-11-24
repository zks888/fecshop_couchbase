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
        $sql = str_replace('":item_id"', 'UUID()', $sql);
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
        $sql = 'CREATE PRIMARY INDEX `idx_id` ON `item`;';
        self::getDb()->createCommand($sql)->execute();
        $sql = 'CREATE INDEX `idx_cartid_productid` ON `item` (`cart_id`, `product_id`);';
        self::getDb()->createCommand($sql)->execute();
    }
}
