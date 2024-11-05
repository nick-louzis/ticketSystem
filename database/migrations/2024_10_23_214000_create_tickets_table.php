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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('name');
            $table->string('email')->nullable();
            $table->integer('number')->nullable();
            $table->text('description');
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
     
            $table->foreignId('category_id')->nullable();
            $table->enum('status',['pending', 'closed', 'in progress'])->default('pending');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
