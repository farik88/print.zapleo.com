<?php

use yii\db\Migration;

class m170215_132918_add_colums extends Migration
{
    public function safeUp()
    {
        $this->addColumn('orders','created_at','integer not null');
        $this->addColumn('orders','updated_at','integer not null');

        $this->addColumn('coupons','created_at','integer not null');
        $this->addColumn('coupons','updated_at','integer not null');
        $this->addColumn('coupons','created_by','integer not null');
        $this->addColumn('coupons','updated_by','integer not null');

        $this->addColumn('covers','created_by','integer not null');
        $this->addColumn('covers','updated_by','integer not null');

        $this->addColumn('deliveries','created_by','integer not null');
        $this->addColumn('deliveries','updated_by','integer not null');

        $this->addColumn('files','created_at','integer not null');
        $this->addColumn('files','updated_at','integer not null');


        $this->addColumn('folders','created_at','integer not null');
        $this->addColumn('folders','updated_at','integer not null');

        $this->addColumn('images','created_at','integer not null');
        $this->addColumn('images','updated_at','integer not null');

        $this->addColumn('labels','created_at','integer not null');
        $this->addColumn('labels','updated_at','integer not null');
        $this->addColumn('labels','created_by','integer not null');
        $this->addColumn('labels','updated_by','integer not null');

        $this->addColumn('markings','created_at','integer not null');
        $this->addColumn('markings','updated_at','integer not null');
        $this->addColumn('markings','created_by','integer not null');
        $this->addColumn('markings','updated_by','integer not null');

        $this->addColumn('order_product','created_at','integer not null');
        $this->addColumn('order_product','updated_at','integer not null');

        $this->addColumn('payments','created_by','integer not null');
        $this->addColumn('payments','updated_by','integer not null');

        $this->addColumn('products','created_at','integer not null');
        $this->addColumn('products','updated_at','integer not null');
        $this->addColumn('products','created_by','integer not null');
        $this->addColumn('products','updated_by','integer not null');

        $this->addColumn('resources','created_at','integer not null');
        $this->addColumn('resources','updated_at','integer not null');

        $this->addColumn('sales','created_at','integer not null');
        $this->addColumn('sales','updated_at','integer not null');
        $this->addColumn('sales','created_by','integer not null');
        $this->addColumn('sales','updated_by','integer not null');
    }

    public function safeDown()
    {
        echo "m170215_132918_add_colums cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
