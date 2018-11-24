<?php
use yii\base\Component;
use yii\db\MigrationInterface;

class m181124_224655_cart_buckets extends Component implements MigrationInterface
{
    public $db = 'couchbase';
    public $compact = false;

    public function up()
    {
        \fecshop\couchbase\models\Cart::create_index();
        \fecshop\couchbase\models\cart\Item::create_index();
    }

    public function down()
    {
        echo "m181124_224655_cart_buckets cannot be reverted.\n";

        return false;
    }
}
