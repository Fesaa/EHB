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
        Schema::create('thread_cloaks', function (Blueprint $table)
        {
            $table->id();
            $table->unsignedBigInteger('thread_id');
            $table->unsignedBigInteger('privilege_id');

            $table->foreign('thread_id')
                ->references('id')
                ->on('threads');

            $table->foreign('privilege_id')
                ->references('id')
                ->on('privileges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thread_cloaks');
    }
};
