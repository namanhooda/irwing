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
        Schema::create('meeting_calendars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('from_date');
            $table->date('to_date');
            $table->string('color')->nullable(); // optional for custom event colors
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_calendars');
    }
};
