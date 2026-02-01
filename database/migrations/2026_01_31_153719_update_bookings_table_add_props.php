<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('queue_number')->nullable()->after('status');
            $table->integer('sequence')->default(0)->after('queue_number');
            $table->foreignId('promo_id')->nullable()->after('schedule_id')->constrained('promos')->onDelete('set null');
            $table->decimal('total_price', 10, 2)->default(0)->after('promo_id');
            DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'booked', 'completed', 'cancelled', 'skipped') DEFAULT 'pending'");
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['promo_id']);
            $table->dropColumn(['queue_number', 'promo_id', 'total_price']);
            DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending', 'booked', 'completed', 'cancelled') DEFAULT 'pending'");
        });
    }
};
