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
    Schema::create('collections', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('slug')->unique();
        $table->string('banner')->nullable();
        $table->text('description')->nullable();
        $table->tinyInteger('status')->default(1);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('collections');
}

};
