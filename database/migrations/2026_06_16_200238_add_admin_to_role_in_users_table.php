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
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role::text = ANY (ARRAY['buyer'::text, 'seller'::text, 'admin'::text]))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['buyer', 'seller', 'admin'])->default('buyer')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (\Illuminate\Support\Facades\DB::getDriverName() === 'pgsql') {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users DROP CONSTRAINT IF EXISTS users_role_check");
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE users ADD CONSTRAINT users_role_check CHECK (role::text = ANY (ARRAY['buyer'::text, 'seller'::text]))");
        } else {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['buyer', 'seller'])->default('buyer')->change();
            });
        }
    }
};
