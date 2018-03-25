<?php

use yii\db\Migration;

/**
 * Handles the creation of table `podbor`.
 */
class m180325_174308_create_podbor_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('podbor', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createTable('podbor_lang', [
            'podbor_id' => $this->integer()->notNull(),
            'lang_id' => $this->string(3)->notNull(),
            'name' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
        ], $tableOptions);

        $this->addPrimaryKey('pk-podbor_lang', 'podbor_lang', ['podbor_id', 'lang_id']);

        $this->addForeignKey('fk-podbor-parent_id', 'podbor', 'parent_id', 'podbor', 'id', 'SET NULL');

        $this->addForeignKey('fk-podbor_lang-podbor_id', 'podbor_lang', 'podbor_id', 'podbor', 'id', 'CASCADE');

        $this->addForeignKey('fk-podbor_lang-lang_id', 'podbor_lang', 'lang_id', 'language', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-podbor_lang-lang_id', 'podbor_lang');

        $this->dropForeignKey('fk-podbor_lang-podbor_id', 'podbor_lang');

        $this->dropForeignKey('fk-podbor-parent_id', 'podbor');

        $this->dropPrimaryKey('pk-podbor_lang', 'podbor_lang');

        $this->dropTable('podbor_lang');

        $this->dropTable('podbor');
    }
}
