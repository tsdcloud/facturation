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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('invoice_no');
            $table->string('tractor');
            $table->string('trailer');
            $table->string('amount_ht')->nullable();
            $table->string('vat')->nullable();
            $table->decimal('amount_paid',8,2);
            $table->decimal('remains',8,2);
            $table->foreignId('mode_payment_id')->constrained();
            $table->foreignId('weighbridge_id')->constrained();
            $table->foreignId('user_id')->constrained();
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
        Schema::dropIfExists('invoices');
    }
};
