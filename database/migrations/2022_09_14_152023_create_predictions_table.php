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
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->string('operation');
            $table->string('tractor');
            $table->string('trailer');
            $table->string('container_number')->unique();
            $table->string('seal_number')->nullable();
            $table->string('loader');
            $table->string('product')->nullable();

            $table->string('head_guerite_entry')->nullable();
            $table->string('guerite_entry')->nullable();
            $table->dateTime('date_weighing_entry')->nullable();
            $table->string('weighing_in')->nullable();

            $table->string('head_geurite_output')->nullable();
            $table->string('geurite_output')->nullable();
            $table->dateTime('date_weighing_output')->nullable();
            $table->string('weighing_out')->nullable();
            $table->string('weighing_status')->nullable();

            $table->foreignId('user_id')->constrained();
            $table->foreignId('partner_id')->constrained();
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
        Schema::dropIfExists('predictions');
    }
};
