<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    // transaction detail ini untuk menyimpan data penumpang dari satu data transaksi. data penumpang bisa lebih dari satu (banyak) dari satu transaksi yang ada (one to many)
    public function up(): void
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('passenger_name')->nullable(false);
            $table->string('passenger_phone')->nullable(false);
            $table->integer('seat_number')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_details');
    }
};
