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
        Schema::create('label_task', function (Blueprint $table) {
            $table->foreignId('label_id')->constrained()->restrictOnDelete();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->primary(['label_id', 'task_id']);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('label_task');
    }
};
