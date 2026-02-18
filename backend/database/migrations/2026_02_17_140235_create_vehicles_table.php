<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('driver_id')
                ->constrained('drivers')
                ->onDelete('cascade');

            $table->string('make');
            $table->string('model');
            $table->string('plate_no')->unique();
            $table->string('color')->nullable();
            $table->unsignedSmallInteger('year')->nullable();

            $table->enum('type', ['standard', 'premium', 'van'])->default('standard');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
