<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class VkresourcesMigration_1005 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'vkresources',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'vk_id',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 10,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'status',
                    array(
                        'type' => Column::TYPE_CHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'vk_id'
                    )
                ),
                new Column(
                    'created_at',
                    array(
                        'type' => Column::TYPE_DATE,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'status'
                    )
                ),
                new Column(
                    'updated_at',
                    array(
                        'type' => Column::TYPE_DATE,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'created_at'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
