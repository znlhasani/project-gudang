<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN role SET DEFAULT 'user'");
        DB::table('users')->whereNull('role')->update(['role' => 'user']);
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users ALTER COLUMN role DROP DEFAULT");
    }
};
