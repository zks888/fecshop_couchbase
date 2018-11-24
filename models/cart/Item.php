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
}
