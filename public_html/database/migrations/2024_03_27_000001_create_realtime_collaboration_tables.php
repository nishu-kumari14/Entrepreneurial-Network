<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Document collaborations table
        Schema::create('document_collaborations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->string('type')->default('document'); // document, code, diagram
            $table->json('current_editors')->nullable(); // Store currently active editors
            $table->json('edit_history')->nullable(); // Store edit history
            $table->timestamps();
        });

        // Chat rooms table
        Schema::create('chat_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('type')->default('general'); // general, code-review, standup
            $table->boolean('is_private')->default(false);
            $table->timestamps();
        });

        // Chat messages table
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_room_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('message');
            $table->string('type')->default('text'); // text, code, file, system
            $table->json('metadata')->nullable(); // For additional message data
            $table->timestamps();
            $table->softDeletes();
        });

        // Code reviews table
        Schema::create('code_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('open'); // open, in_review, approved, rejected
            $table->string('branch_name')->nullable();
            $table->json('files_changed')->nullable();
            $table->timestamps();
        });

        // Code review comments table
        Schema::create('code_review_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->string('file_path')->nullable();
            $table->integer('line_number')->nullable();
            $table->string('status')->default('active'); // active, resolved, outdated
            $table->timestamps();
        });

        // Code review reactions table
        Schema::create('code_review_reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('code_review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reaction'); // approve, request_changes, comment
            $table->timestamps();
            $table->unique(['code_review_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('code_review_reactions');
        Schema::dropIfExists('code_review_comments');
        Schema::dropIfExists('code_reviews');
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('chat_rooms');
        Schema::dropIfExists('document_collaborations');
    }
}; 