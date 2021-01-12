<?php

use yii\db\Migration;

/**
 * Class m210112_090821_add_uk_language
 */
class m210112_090821_add_uk_language extends Migration
{
    public $tables = [
        'block_lang',
        'brand_lang',
        'category_lang',
        'complect_lang',
        'currency_lang',
        'delivery_lang',
        'feature_lang',
        'menu_item_lang',
        'page_lang',
        'payment_lang',
        'podbor_lang',
        'product_lang',
        'setting_lang',
        'status_lang',
        'unit_lang',
        'value_lang',
        'variant_lang',
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('language', ['id', 'name', 'position'], [
            ['uk', 'Український', 2],
        ]);

        foreach ($this->tables as $table) {
            Yii::$app->db->createCommand("CREATE TEMPORARY TABLE `tmp_" . $table . "` SELECT * FROM `" . $table . "`;")->execute();
            Yii::$app->db->createCommand("UPDATE `tmp_" . $table . "` SET `lang_id` = 'uk';")->execute();
            Yii::$app->db->createCommand("INSERT INTO `" . $table . "` SELECT * FROM `tmp_" . $table . "`;")->execute();
            Yii::$app->db->createCommand("DROP TEMPORARY TABLE IF EXISTS `tmp_" . $table . "`;")->execute();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        foreach ($this->tables as $table) {
            $this->delete($table, ['lang_id' => 'uk']);
        }

        $this->delete('language', ['id' => 'uk']);
    }
}
