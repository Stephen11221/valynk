<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('development_children', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->unsignedTinyInteger('age');
            $t->string('grade');
            $t->string('school')->nullable();
            $t->timestamps();
        });
        Schema::create('development_assessments', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('development_child_id')->constrained()->cascadeOnDelete();
            $t->longText('answers');
            $t->unsignedTinyInteger('step')->default(1);
            $t->timestamp('consented_at')->nullable();
            $t->timestamps();
        });
        Schema::create('development_connections', function (Blueprint $t): void {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('provider_profile_id')->constrained()->cascadeOnDelete();
            $t->foreignId('development_child_id')->constrained()->cascadeOnDelete();
            $t->string('status')->default('Requested');
            $t->timestamps();
            $t->unique(['user_id', 'provider_profile_id', 'development_child_id'], 'development_connection_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('development_connections');
        Schema::dropIfExists('development_assessments');
        Schema::dropIfExists('development_children');
    }
};
