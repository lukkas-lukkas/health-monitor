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
        Schema::create('health_data', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->dateTime('started_at');
            $table->dateTime('finished_at');
            $table->integer('avg_bpm');
            $table->integer('steps_total');
            $table->dateTime('created_at');
            $table->text('anomalies')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_data');
    }
};
