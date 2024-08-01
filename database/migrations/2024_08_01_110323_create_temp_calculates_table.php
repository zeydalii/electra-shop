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
        Schema::create('temp_calculates', function (Blueprint $table) {
            $table->id();
            $table->string('session_id');
            $table->integer('item_id');
            $table->integer('jumlah')->default(1);
            $table->integer('harga');
            $table->integer('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_calculates');
    }
};
