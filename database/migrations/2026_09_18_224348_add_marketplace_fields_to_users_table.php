<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('password');
            $table->enum('role', ['user', 'admin'])->default('user')->after('phone');
            $table->string('province')->nullable()->after('role');
            $table->string('city')->nullable()->after('province');
            $table->string('district')->nullable()->after('city');
            $table->string('avatar')->nullable()->after('district');
            $table->decimal('rating', 3, 2)->default(0)->after('avatar');
            $table->integer('total_transactions')->default(0)->after('rating');
            $table->timestamp('joined_at')->nullable()->after('total_transactions');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'role', 'province', 'city', 'district', 
                'avatar', 'rating', 'total_transactions', 'joined_at'
            ]);
        });
    }
};