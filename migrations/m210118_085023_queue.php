<?php

use yii\db\Migration;

/**
 * Class m210118_085023_queue
 */
class m210118_085023_queue extends Migration
{
    public $tableName = '{{%queue}}';
    public $tableOptions;

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'channel' => $this->string()->notNull(),
            'job' => $this->binary()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'started_at' => $this->integer(),
            'finished_at' => $this->integer(),
        ], $this->tableOptions);

        $this->createIndex('channel', $this->tableName, 'channel');
        $this->createIndex('started_at', $this->tableName, 'started_at');

        $this->addColumn($this->tableName, 'timeout', $this->integer()->defaultValue(0)->notNull()->after('created_at'));

        if ($this->db->driverName !== 'sqlite') {
            $this->renameColumn($this->tableName, 'created_at', 'pushed_at');
            $this->addColumn($this->tableName, 'ttr', $this->integer()->notNull()->after('pushed_at'));
            $this->renameColumn($this->tableName, 'timeout', 'delay');
            $this->dropIndex('started_at', $this->tableName);
            $this->renameColumn($this->tableName, 'started_at', 'reserved_at');
            $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
            $this->addColumn($this->tableName, 'attempt', $this->integer()->after('reserved_at'));
            $this->renameColumn($this->tableName, 'finished_at', 'done_at');
        } else {
            $this->dropTable($this->tableName);
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'channel' => $this->string()->notNull(),
                'job' => $this->binary()->notNull(),
                'pushed_at' => $this->integer()->notNull(),
                'ttr' => $this->integer()->notNull(),
                'delay' => $this->integer()->notNull(),
                'reserved_at' => $this->integer(),
                'attempt' => $this->integer(),
                'done_at' => $this->integer(),
            ]);
            $this->createIndex('channel', $this->tableName, 'channel');
            $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
        }

        $this->addColumn($this->tableName, 'priority', $this->integer()->unsigned()->notNull()->defaultValue(1024)->after('delay'));
        $this->createIndex('priority', $this->tableName, 'priority');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('priority', $this->tableName);
        $this->dropColumn($this->tableName, 'priority');

        if ($this->db->driverName !== 'sqlite') {
            $this->renameColumn($this->tableName, 'done_at', 'finished_at');
            $this->dropColumn($this->tableName, 'attempt');
            $this->dropIndex('reserved_at', $this->tableName);
            $this->renameColumn($this->tableName, 'reserved_at', 'started_at');
            $this->createIndex('started_at', $this->tableName, 'started_at');
            $this->renameColumn($this->tableName, 'delay', 'timeout');
            $this->dropColumn($this->tableName, 'ttr');
            $this->renameColumn($this->tableName, 'pushed_at', 'created_at');
        } else {
            $this->dropTable($this->tableName);
            $this->createTable($this->tableName, [
                'id' => $this->primaryKey(),
                'channel' => $this->string()->notNull(),
                'job' => $this->binary()->notNull(),
                'created_at' => $this->integer()->notNull(),
                'timeout' => $this->integer()->notNull(),
                'started_at' => $this->integer(),
                'finished_at' => $this->integer(),
            ]);
            $this->createIndex('channel', $this->tableName, 'channel');
            $this->createIndex('started_at', $this->tableName, 'started_at');
        }

        $this->dropColumn($this->tableName, 'timeout');

        $this->dropTable($this->tableName);
    }
}
