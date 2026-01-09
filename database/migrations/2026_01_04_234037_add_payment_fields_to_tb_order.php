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
    Schema::table('tb_order', function (Blueprint $table) {
        $table->string('payment_method')->default('COD')->after('ward');
        $table->string('payment_status')->default('unpaid')->after('payment_method');
        $table->string('payment_code')->nullable()->after('payment_status');
    });
}

public function down()
{
    Schema::table('tb_order', function (Blueprint $table) {
        $table->dropColumn(['payment_method', 'payment_status', 'payment_code']);
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
};
