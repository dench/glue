<?php

use yii\db\Migration;

/**
 * Class m201013_075013_add_product_id_to_review_table
 */
class m201013_075013_add_product_id_to_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%review}}', 'product_id', $this->integer());

        $this->addForeignKey('fk-review-product_id', '{{%review}}', 'product_id', '{{%product}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-review-product_id', '{{%review}}');

        $this->dropColumn('{{%review}}', 'product_id');
    }
}
