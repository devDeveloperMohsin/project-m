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
        Schema::create('subtask_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subtask_id')->constrained()->onDelete('cascade'); // Foreign key to subtasks table
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key to users table
            $table->string('role'); // Role of the user in the subtask (e.g., 'owner', 'member')
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subtask_users');
    }
};
