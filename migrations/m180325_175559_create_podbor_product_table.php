<?php

use yii\db\Migration;

/**
 * Handles the creation of table `podbor_product`.
 */
class m180325_175559_create_podbor_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('podbor_product', [
            'podbor_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('pk-podbor_product', 'podbor_product', ['podbor_id', 'product_id']);

        $this->addForeignKey('fk-podbor_product-product_id', 'podbor_product', 'product_id', 'product', 'id', 'CASCADE');

        $this->addForeignKey('fk-podbor_product-podbor_id', 'podbor_product', 'podbor_id', 'podbor', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-podbor_product-podbor_id', 'podbor_product');

        $this->dropForeignKey('fk-podbor_product-product_id', 'podbor_product');

        $this->dropPrimaryKey('pk-podbor_product', 'podbor_product');

        $this->dropTable('podbor_product');
    }
}
