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
        Schema::create('qrp_officers', function (Blueprint $table) {
            $table->id();
    $table->unsignedBigInteger('qrp_id'); // must be unsignedBigInteger
    $table->foreign('qrp_id')->references('id')->on('qrp_forms')->onDelete('cascade');

    $table->unsignedBigInteger('profile_id')->nullable();
    $table->string('staff_no')->nullable();
    $table->string('officer_name');
    $table->unsignedBigInteger('unit')->nullable();
    $table->unsignedBigInteger('unit_office')->nullable();
    $table->unsignedBigInteger('division')->nullable();
    $table->unsignedBigInteger('designation')->nullable();
    $table->enum('mode', ['Online', 'Offline'])->default('Online');
    $table->string('email')->nullable();
    $table->string('contact')->nullable();

    $table->date('meeting_from')->nullable();
    $table->date('meeting_to')->nullable();
    $table->unsignedBigInteger('country')->nullable();
    $table->string('city')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qrp_officers');
    }
};
