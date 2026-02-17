<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('drivers', function (Blueprint $table) {
        $table->id();

        // lidhje me users table
        $table->foreignId('user_id')
              ->constrained()
              ->onDelete('cascade');

        // informacion për shoferin
        $table->string('license_no')->unique();
        $table->boolean('is_active')->default(true);
        $table->decimal('avg_rating', 3, 2)->default(0);

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
