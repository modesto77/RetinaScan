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
    Schema::create('follow_ups', function (Blueprint $table) {
        $table->id();
        $table->foreignId('patient_id')->constrained()->onDelete('cascade');
        
        // LE RENDEZ-VOUS
        $table->date('scheduled_date'); // Quand ?
        $table->string('reason');       // Pourquoi ? (Ex: "Contrôle post-laser")
        
        // ÉTAT
        // 'prevu', 'termine', 'annule'
        $table->string('status')->default('prevu');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folllow_ups');
    }
};
