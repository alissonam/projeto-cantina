<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->decimal('subtotal');
            $table->timestamps();
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('order_id', 'fk_o_order_id')
                ->references('id')
                ->on('orders')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->foreign('product_id', 'fk_p_product_id')
                ->references('id')
                ->on('products')
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign('fk_o_order_id');
            $table->dropForeign('fk_p_product_id');
        });

        Schema::dropIfExists('items');
    }
};
