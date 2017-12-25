<?php

use yii\db\Migration;

/**
 * Handles the creation of table `question`.
 */
class m171224_114143_create_question_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'question' => $this->text(),
            'answer' => $this->text(),
            'email' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'position' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('question');
    }
}
