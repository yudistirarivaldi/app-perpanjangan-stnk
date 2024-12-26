<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxPaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('tax_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
            $table->date('payment_date');
            $table->decimal('payment_amount', 10, 2);
            $table->enum('payment_method', ['cash', 'transfer', 'online']);
            $table->enum('payment_status', ['success', 'pending', 'failed']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_payments');
    }
}