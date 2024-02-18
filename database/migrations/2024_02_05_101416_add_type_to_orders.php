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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('polica_name')->nullable();
            $table->string('polica_number_telex')->nullable();
            $table->string('polica_number_of_delivery')->nullable();
            $table->string('polica_port')->nullable();
            $table->string('polica_file')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('polica_name')->nullable();
            $table->string('polica_number_telex')->nullable();
            $table->string('polica_number_of_delivery')->nullable();
            $table->string('polica_port')->nullable();
            $table->string('polica_file')->nullable();
        });
    }
};
