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
        Schema::create('wallet_enteries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_id');
            $table->foreign('wallet_id')->on('wallets')->references('id')->cascadeOnDelete();
            $table->float('amount');
            $table->enum('type',['cr','dr']);
            $table->string('description');
            $table->unsignedBigInteger('transaction_parent_id')->nullable();
            $table->foreign('transaction_parent_id')->references('id')->on('wallet_enteries')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_enteries');
    }
};
