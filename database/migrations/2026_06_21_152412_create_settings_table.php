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
Schema::create('settings', function (Blueprint $table) {
    $table->id();

    $table->decimal('preset_setter_survival_rate', 5, 2);
    $table->decimal('preset_hatcher_survival_rate', 5, 2);
    $table->decimal('preset_order_buffer', 5, 2);

    $table->integer('preset_setter_days');
    $table->integer('preset_hatcher_days');

    $table->integer('simulation_minutes_per_day')->default(1);

    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
