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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('pfp_asset_id')->nullable()->constrained('assets');
            $table->foreignId('banner_asset_id')->nullable()->constrained('assets');
            $table->date('birthday')->nullable();
            $table->text('bio')->nullable();
            $table->string('pronouns')->nullable();
            $table->string('location')->nullable();
            $table->string('title')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
