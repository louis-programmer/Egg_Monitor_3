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
       Schema::create('machines', function (Blueprint $table) {
    $table->id();

    $table->string('machine_name');

    $table->enum('machine_type', [
        'setter',
        'hatcher'
    ]);

    $table->enum('brand', [
        'solera',
        'jamesway'
    ]);

    $table->integer('maximum_load');

    $table->integer('minimum_load');

    $table->boolean('is_active')->default(true);

    $table->enum('status', [
        'available',
        'processing',
        'waiting_transfer',
        'waiting_unload',
        'paused',
        'maintenance'
    ])->default('available');

    $table->dateTime('available_on')
        ->nullable();

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
