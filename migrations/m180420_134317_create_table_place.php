<?php

use yii\db\Migration;

/**
 * Class m180420_134317_create_table_place
 */
class m180420_134317_create_table_place extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('place',[
            'id' => $this->primaryKey()->unsigned(),
            'place_id' => $this->string(45)->notNull(),
            'lat' => $this->string(45)->notNull(),
            'lng' => $this->string(45)->notNull(),
            'country_code' => $this->string(2)->notNull(),
            'is_country' => $this->boolean()->notNull()
        ],'ENGINE InnoDB');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('place');
    }

    
    // Use up()/down() to run migration code without a transaction.
    // public function up()
    // {
    //     $this->createTable('place',[
    //         'id' => $this->primaryKey()->unsigned(),
    //         'place_id' => $this->string(45)->notNull(),
    //         'lat' => $this->string(45)->notNull(),
    //         'lng' => $this->string(45)->notNull(),
    //         'country_code' => $this->string(2)->notNull(),
    //         'is_country' => $this->boolean()->notNull()
    //     ]);
    // }

    // public function down()
    // {
    //     $this->dropTable('place');
    // }
    
}
