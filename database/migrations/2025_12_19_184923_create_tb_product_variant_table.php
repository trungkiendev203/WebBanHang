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
Schema::create('tb_product_variant', function (Blueprint $table) {
    $table->id('id_product_variant');
    $table->unsignedBigInteger('id_product');
    $table->string('size');
    $table->integer('quantity');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_product_variant');
    }
};
