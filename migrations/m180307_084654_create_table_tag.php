<?php

use yii\db\Migration;

/**
 * Class m180307_084654_create_table_tag
 */
class m180307_084654_create_table_tag extends Migration
{
    public function safeUp()
    {
        $options = ($this->db->getDriverName() === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'frequency' => $this->integer()->notNull()->defaultValue(0),
            'hidden' => $this->smallInteger(1)->notNull()->defaultValue(1),
            'language' => $this->string(8)->null()->defaultValue(null),
            'createdBy' => $this->integer(11)->null()->defaultValue(null),
            'createdAt' => $this->dateTime()->null()->defaultValue(null),
            'updatedAt' => $this->dateTime()->null()->defaultValue(null),
        ], $options);

        $this->createIndex('hidden', '{{%tag}}', ['hidden']);
        $this->createIndex('language', '{{%tag}}', ['language']);

        $this->addForeignKey(
            'fk-tag-to-auth',
            '{{%tag}}',
            'createdBy',
            '{{%auth}}',
            'id',
            'SET NULL',
            'RESTRICT'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-tag-to-auth', '{{%tag}}');
        $this->dropTable('{{%tag}}');
    }
}
