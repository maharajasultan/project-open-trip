<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->unique();   // ID unik untuk Midtrans
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mountain_id')->constrained()->onDelete('cascade');

            // === DATA DIRI PESERTA ===
            $table->string('full_name');            // Nama lengkap
            $table->integer('age');                 // Umur
            $table->text('address');                // Alamat lengkap
            $table->string('no_wa');                // Nomor WhatsApp aktif
            $table->string('email');                // Email aktif
            $table->integer('participant_count');   // Jumlah peserta

            // === DATA TRANSAKSI ===
            $table->decimal('price_per_person', 10, 2);  // Harga per orang
            $table->decimal('total_price', 10, 2);        // Total harga
            $table->enum('status', ['pending', 'success', 'failed', 'expired'])
                  ->default('pending');

            // === DATA MIDTRANS ===
            $table->string('snap_token')->nullable();     // Token dari Midtrans Snap
            $table->string('payment_type')->nullable();   // Metode pembayaran
            $table->timestamp('paid_at')->nullable();     // Waktu pembayaran sukses

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};