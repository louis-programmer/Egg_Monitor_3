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
        Schema::create('batches', function (Blueprint $table) {
    $table->id();

    $table->foreignId('order_id')
        ->constrained()
        ->cascadeOnDelete();


    $table->foreignId('machine_id')
        ->constrained()
        ->cascadeOnDelete();

        $table->enum('machine_type', [
            'setter',
            'hatcher',
        ]);

    $table->integer('batch_amount');

    $table->timestamp('started_at')
        ->nullable();

    $table->timestamp('day0_at')
        ->nullable();

    $table->timestamp('day18_at')
        ->nullable();

    $table->timestamp('day19_at')
        ->nullable();

    $table->timestamp('day21_at')
        ->nullable();

    $table->integer('survived_day18')
        ->nullable();

    $table->integer('spoiled_day18')
        ->nullable();

    $table->integer('survived_day21')
        ->nullable();

    $table->integer('spoiled_day21')
        ->nullable();

    $table->enum('status', [
        'pending',
        'running',
        'paused',
        'completed',
    ])->default('pending');

    $table->text('remarks')
        ->nullable();

    $table->timestamps();

            $table->integer('current_day')
    ->default(0);

    $table->timestamp('completed_at')
    ->nullable();

});


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
