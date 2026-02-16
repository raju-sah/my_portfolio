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
        Schema::create('document_chunks', function (Blueprint $table) {
            $table->id();
            $table->text('content'); // The actual text chunk
            $table->json('embedding')->nullable(); // Vector storage (MySQL 8/MariaDB)
            $table->json('metadata')->nullable(); // Source URL, type, title, etc.
            $table->string('source_type')->index(); // 'resume', 'web', 'github'
            $table->unsignedBigInteger('token_count')->default(0);
            $table->timestamps();
            
            // Fulltext index for hybrid search
            $table->fullText('content'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_chunks');
    }
};
