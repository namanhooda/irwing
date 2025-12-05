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
         Schema::create('multilateral_engagements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->text('engagement');
            $table->text('key_offerings')->nullable();
            $table->text('key_asks')->nullable();
            $table->timestamps();

            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multilateral_engagements');
    }
};
