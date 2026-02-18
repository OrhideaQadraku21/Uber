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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();

            // lidhje me tabelen users
            $table->foreignId('user_id')
                  ->unique()              // një user = një driver
                  ->constrained()
                  ->cascadeOnDelete();

            // te dhenat e shoferit
            $table->string('license_no')->unique();
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('avg_rating', 3, 2)->default(0);

            // status online/offline (shume e rendesishme per Uber)
            $table->boolean('is_online')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
