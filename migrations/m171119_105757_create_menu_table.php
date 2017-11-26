<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m171119_105757_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('menu_item', [
            'id' => $this->primaryKey(),
            'menu_id' => $this->integer()->notNull(),
            'parent_id' => $this->integer(),
            'icon' => $this->string(32),
            'url' => $this->string(),
            'link' => $this->string(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('menu_item_lang', [
            'menu_item_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'label' => $this->string()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk-menu_item-menu_id', 'menu_item', 'menu_id', 'menu', 'id', 'CASCADE');

        $this->addForeignKey('fk-menu_item-parent_id', 'menu_item', 'parent_id', 'menu_item', 'id', 'CASCADE');

        $this->addPrimaryKey('pk-menu_item_lang', 'menu_item_lang', ['menu_item_id', 'lang_id']);

        $this->addForeignKey('fk-menu_item_lang-menu_item_id', 'menu_item_lang', 'menu_item_id', 'menu_item', 'id', 'CASCADE');

        $this->addForeignKey('fk-menu_item_lang-lang_id', 'menu_item_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-menu_item_lang-lang_id', 'menu_item_lang');

        $this->dropForeignKey('fk-menu_item_lang-menu_item_id', 'menu_item_lang');

        $this->dropPrimaryKey('pk-menu_item_lang', 'menu_item_lang');

        $this->dropForeignKey('fk-menu_item-menu_id', 'menu_item');

        $this->dropTable('menu');

        $this->dropTable('menu_item');

        $this->dropTable('menu_item_lang');
    }
}
