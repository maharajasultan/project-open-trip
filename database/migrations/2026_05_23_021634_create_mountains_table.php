<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mountains', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location')->nullable();
            $table->decimal('price', 10, 2);
            $table->dateTime('departure_date');
            $table->integer('quota');
            $table->integer('registered_count')->default(0);
            $table->text('description');
            $table->longText('itinerary');          // Detail jadwal perjalanan
            $table->string('image')->nullable();    // Path gambar
            $table->integer('altitude')->nullable(); // Ketinggian mdpl
            $table->string('difficulty')->nullable();// Easy, Medium, Hard
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mountains');
    }
};