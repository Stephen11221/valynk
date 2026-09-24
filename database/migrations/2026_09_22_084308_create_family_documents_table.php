<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('family_documents', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('family_folder_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('child_name', 100)->nullable();
            $table->string('path');
            $table->string('extension', 10);
            $table->unsignedBigInteger('size');
            $table->timestamps();
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('family_documents');
    }
};
