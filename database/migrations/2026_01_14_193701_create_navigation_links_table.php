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
        Schema::create('navigation_links', function (Blueprint $table) {
            $table->id();
            $table->string('link_name');
            $table->string('link_route');
            $table->integer('link_position')->nullable();
            $table->string('link_icon')->nullable();
            $table->enum('link_location',['header', 'footer'])->default('header');
            $table->enum('link_status',['active','inactive'])->default('active');
            $table->enum('shows_on_frontend',['yes','no'])->default('yes');
            $table->foreignId('user_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navigation_links');
    }
};
