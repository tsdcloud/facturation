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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string("type_report");
            $table->string("shift");
            $table->integer("number_incident");
            $table->text("production_comment");
            $table->text("disciplinary_comment");
            $table->text("incidental_comment");
            $table->string("attachment")->nullable();
            $table->integer("total_complete_weighing");
            $table->integer("total_complete_weighing_cash");
            $table->integer("total_complete_weighing_prepaid");
            $table->integer("total_complete_weighing_invoiced");
            $table->integer("total_incomplete_weighing");
            $table->integer("total_incomplete_weighing_cash");
            $table->integer("total_incomplete_weighing_prepaid");
            $table->integer("total_incomplete_weighing_invoiced");
            $table->string("name_hse_1")->nullable();
            $table->string("name_hse_2")->nullable();
            $table->string("weighing_operator")->nullable();
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
        Schema::dropIfExists('reports');
    }
};
