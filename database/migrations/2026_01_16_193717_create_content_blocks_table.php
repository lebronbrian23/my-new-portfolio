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
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('years_of_experience')->default(0);
            $table->integer('projects_completed')->default(0);
            $table->string('photo')->nullable();
            $table->enum('content_block_section',['home','about','work','skill','contact'])->nullable();
            $table->enum('content_block_status',['active','inactive'])->default('active');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('navigation_link_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
