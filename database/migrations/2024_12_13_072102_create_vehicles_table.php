<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('plate_number')->unique();
            $table->foreignId('category_id')->after('id')->nullable()->constrained('category')->onDelete('cascade');
            $table->foreignId('merk_id')->after('id')->nullable()->constrained('merk')->onDelete('cascade');
            // $table->enum('vehicle_type', ['motor', 'mobil', 'lainnya']);
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->date('tax_due_date');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}