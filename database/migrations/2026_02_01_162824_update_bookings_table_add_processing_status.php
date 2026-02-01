<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('bookings', 'processing_started_at')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->timestamp('processing_started_at')->nullable()->after('status');
            });
        }

        // Sanitize data: 'pending' or other invalid values -> 'booked'
        DB::update("UPDATE bookings SET status = 'booked' WHERE status NOT IN ('booked', 'completed', 'cancelled', 'skipped')");

        // Add 'processing' to enum
        DB::statement("ALTER TABLE bookings MODIFY COLUMN status ENUM('booked', 'completed', 'cancelled', 'skipped', 'processing') DEFAULT 'booked'");
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('processing_started_at');
        });
    }
};
