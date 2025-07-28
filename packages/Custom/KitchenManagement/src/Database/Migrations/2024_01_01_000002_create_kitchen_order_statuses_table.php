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
        Schema::create('kitchen_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_id');
            $table->string('kitchen_status'); // received_in_kitchen, preparing, etc.
            $table->unsignedInteger('assigned_delivery_user_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('status_changed_at');
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->index(['order_id', 'kitchen_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kitchen_order_statuses');
    }
}; 