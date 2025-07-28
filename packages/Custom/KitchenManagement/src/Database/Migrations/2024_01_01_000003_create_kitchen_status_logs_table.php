<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kitchen_status_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->unsignedInteger('changed_by'); // admin or delivery user ID
            $table->string('changed_by_type'); // admin, delivery_user
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchen_status_logs');
    }
}; 