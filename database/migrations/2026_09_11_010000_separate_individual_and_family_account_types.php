<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->where('account_type', 'Individual / Family')
            ->update(['account_type' => 'Individual']);
    }

    public function down(): void
    {
        // Existing combined records cannot be distinguished safely after this migration.
    }
};
