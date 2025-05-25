<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->morphs('subject'); // subject_id and subject_type
            $table->string('type'); // created_post, commented, liked, etc.
            $table->json('data')->nullable(); // Additional data about the activity
            $table->enum('visibility', ['public', 'private', 'followers'])->default('public');
            $table->boolean('is_public')->default(true);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
}; 