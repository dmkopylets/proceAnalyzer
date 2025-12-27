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
        Schema::create('exchange_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exchange_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('pair_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('price', 20, 10);
            $table->timestamps();
            $table->unique(['exchange_id', 'pair_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exchange_prices');
    }
};
