<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->softDeletes();
            $table->enum('status', ['ACTIVE', 'SUSPENDED', 'BANNED'])->default('ACTIVE');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('status', ['ACTIVE', 'SUSPENDED', 'BANNED'])->default('ACTIVE');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED', 'COMPLETED'])->default('PENDING');
            $table->string('bank_account');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('disputes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('reason');
            $table->enum('status', ['OPEN', 'RESOLVED_REFUNDED', 'RESOLVED_RELEASED'])->default('OPEN');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disputes');
        Schema::dropIfExists('withdrawals');
        Schema::dropIfExists('shops');
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropSoftDeletes();
        });
        
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
