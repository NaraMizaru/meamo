<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique(); // Nullable if purely auto
            $table->boolean('is_auto')->default(false);
            $table->foreignId('service_id')->nullable()->constrained('services')->onDelete('cascade');
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->integer('discount_percentage')->nullable();
            $table->integer('quota')->nullable(); // Null = unlimited
            $table->integer('used_count')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
