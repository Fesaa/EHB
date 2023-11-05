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
        Schema::create('thread_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('forum_id')->constrained('forums');
            $table->enum('type', ['text', 'big-text', 'bool']); // Keeping it simple, I hate js
            $table->string('label');
            $table->string('description')->nullable();
            $table->string('placeholder')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thread_forms');
    }
};
