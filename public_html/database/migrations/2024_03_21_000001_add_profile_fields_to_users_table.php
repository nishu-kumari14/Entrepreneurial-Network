<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('entrepreneur');
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->json('skills')->nullable();
            $table->string('profile_image')->nullable();
            $table->json('interests')->nullable();
            $table->string('company')->nullable();
            $table->string('website')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->boolean('is_verified')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'bio',
                'location',
                'skills',
                'profile_image',
                'interests',
                'company',
                'website',
                'linkedin',
                'twitter',
                'is_verified'
            ]);
        });
    }
}; 