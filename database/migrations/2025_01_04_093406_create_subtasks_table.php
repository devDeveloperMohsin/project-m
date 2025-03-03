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
        Schema::create('subtasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained();
            $table->string('title', 400);
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->string('priority')->nullable();
            $table->string('type')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->integer('sorting')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtasks');
    }
};
