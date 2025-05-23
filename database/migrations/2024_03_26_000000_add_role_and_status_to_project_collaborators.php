<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->string('role')->default('member')->after('user_id');
            $table->string('status')->default('active')->after('role');
        });
    }

    public function down(): void
    {
        Schema::table('project_collaborators', function (Blueprint $table) {
            $table->dropColumn(['role', 'status']);
        });
    }
}; 