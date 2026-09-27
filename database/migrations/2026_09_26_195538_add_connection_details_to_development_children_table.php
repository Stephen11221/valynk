<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('development_children', function (Blueprint $table): void {
            $table->string('solution', 180)->nullable();
            $table->text('pwd_status')->nullable();
            $table->text('pwd_details')->nullable();
            $table->text('support_notes')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('development_children', function (Blueprint $table): void {
            $table->dropColumn(['solution', 'pwd_status', 'pwd_details', 'support_notes']);
        });
    }
};
