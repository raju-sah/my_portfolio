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
        Schema::create('valentine_submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('sender_name');
            $table->text('message');
            $table->enum('day_type', ['rose', 'propose', 'chocolate', 'teddy', 'promise', 'hug', 'kiss', 'valentine']);
            $table->unsignedInteger('open_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->json('meta_data')->nullable(); // For date ideas, love quote, etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('valentine_submissions');
    }
};
