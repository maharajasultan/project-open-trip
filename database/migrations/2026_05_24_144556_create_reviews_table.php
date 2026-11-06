<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');
 
            // Hanya user yang punya transaksi sukses boleh review
            $table->foreignId('transaction_id')
                  ->constrained()
                  ->onDelete('cascade');
 
            $table->tinyInteger('rating');          // 1 – 5 bintang
            $table->text('comment');                // Isi komentar
            $table->boolean('is_visible')->default(true); // Admin bisa sembunyikan
 
            $table->timestamps();
 
            // Satu user hanya bisa review satu kali per gunung
            $table->unique(['user_id', 'mountain_id']);
        });
    }
 
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};