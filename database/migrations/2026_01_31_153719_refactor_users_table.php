<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'user'])->default('user')->after('id');
            $table->dropUnique(['email']);
            $table->string('email')->nullable()->change();
            $table->string('phone_number')->nullable(false)->unique()->change();
        });

        // Drop admins table
        Schema::dropIfExists('admins');
    }

    public function down(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            // Revert email
            // $table->string('email')->nullable(false)->unique()->change(); // Risky if nulls exist
            $table->dropUnique(['phone_number']);
            $table->string('phone_number')->nullable()->change();
        });
    }
};
