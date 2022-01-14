<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%history_of_balance}}`.
 */
class m220114_181037_create_history_of_balance_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%history_of_balance}}', [
            'id' => $this->primaryKey(),
            'organization_id' => $this->integer()->notNull(),
            'sum' => $this->string()->notNull(),
            'description' => $this->string(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'organization_id',  // это "условное имя" ключа
            'history_of_balance', // это название текущей таблицы
            'organization_id', // это имя поля в текущей таблице, которое будет ключом
            'organizations', // это имя таблицы, с которой хотим связаться
            'id', // это поле таблицы, с которым хотим связаться
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%history_of_balance}}');
    }
}
