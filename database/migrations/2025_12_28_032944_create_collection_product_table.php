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
Schema::create('collection_product', function (Blueprint $table) {
    $table->unsignedBigInteger('collection_id');
    $table->unsignedInteger('product_id'); // 🔥 QUAN TRỌNG

    $table->primary(['collection_id', 'product_id']);

    $table->foreign('collection_id')
          ->references('id')->on('collections')
          ->onDelete('cascade');

    $table->foreign('product_id')
          ->references('id_product')->on('tb_product')
          ->onDelete('cascade');
});

}

public function down()
{
    Schema::dropIfExists('collection_product');
}

};
