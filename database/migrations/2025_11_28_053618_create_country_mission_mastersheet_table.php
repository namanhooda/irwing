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
        Schema::create('country_mission_mastersheet', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->text('india_key_offerings')->nullable();
            $table->text('country_asks')->nullable();
            $table->text('engagement_status')->nullable();
            $table->date('last_meeting_date')->nullable();

            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_mission_mastersheet');
    }
};
