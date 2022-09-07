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
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('seen_entry_control')->nullable();
            $table->string('name_controleur_input')->nullable();
            $table->dateTime('date_entry')->nullable();
            $table->string('seen_exit_control')->nullable();
            $table->string('name_controleur_ouput')->nullable();
            $table->string('date_exit')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            //
        });
    }
};
