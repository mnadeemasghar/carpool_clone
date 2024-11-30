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
        Schema::table('rides', function (Blueprint $table) {
            $table->dropColumn('pick_location');
            $table->dropColumn('drop_location');

            $table->unsignedBigInteger('pick_location_id');
            $table->foreign('pick_location_id')->on('addresses')->references('id')->cascadeOnDelete();
            
            $table->unsignedBigInteger('drop_location_id');
            $table->foreign('drop_location_id')->on('addresses')->references('id')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->string('pick_location');
            $table->string('drop_location');
            $table->dropForeign(['pick_location_id']);
            $table->dropForeign(['drop_location_id']);
        });
    }
};
