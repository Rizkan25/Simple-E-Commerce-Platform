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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_cod_enabled')->default(true)->after('status');
            $table->string('discount_type')->nullable()->after('is_cod_enabled')->comment('percentage or fixed');
            $table->decimal('discount_amount', 15, 2)->nullable()->after('discount_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_cod_enabled', 'discount_type', 'discount_amount']);
        });
    }
};
