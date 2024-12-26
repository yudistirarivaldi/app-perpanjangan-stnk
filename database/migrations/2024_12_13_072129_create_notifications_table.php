<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
public function up()
{
    Schema::create('notifications', function (Blueprint $table) {
        $table->id();
        $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('cascade');
        $table->text('message');
        $table->timestamp('notification_date')->nullable();
        $table->enum('status', ['sent', 'failed']);
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('notifications');
}
}