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
        Schema::create('weekday_store_hours', function (Blueprint $table) {
            $table->id();
            $table->time('open');
            $table->time('close');
            $table->time('break_time_start');
            $table->time('break_time_end');
            $table->boolean('every_other_week')->default(false);
            $table->timestamps();

            $table->foreignId('weekday_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekday_store_hours');
    }
};
