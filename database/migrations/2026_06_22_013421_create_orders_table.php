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
        Schema::create('orders', function (Blueprint $table) {
    $table->id();

    $table->foreignId('customer_id')
        ->constrained()
        ->cascadeOnDelete();

    $table->integer('order_amount');

    $table->decimal('order_buffer', 5, 2);

    $table->decimal('setter_survival_rate', 5, 2);

    $table->decimal('hatcher_survival_rate', 5, 2);

    $table->integer('projected_hatched')->nullable();

    $table->integer('projected_spoilage')->nullable();

    $table->integer('actual_hatched')->nullable();

    $table->integer('actual_spoilage')->nullable();

    $table->enum('state', [
        'setter',
        'hatcher',
        'hatched',
        'complete',
        'cancelled',
        'paused',
    ])->default('setter');

    $table->string('status')
    ->default('pending');

    $table->text('remarks')
        ->nullable();

    $table->timestamp('started_at')
        ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
