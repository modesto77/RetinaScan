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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();

            // LIEN AVEC LE MÉDECIN (Crucial pour la confidentialité)
            // Si le médecin supprime son compte, ses patients sont supprimés (cascade)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Identité
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['Homme', 'Femme', 'Autre']);
            $table->string('diabetes_type')->default('Type 2');
            $table->integer('diagnosis_year')->nullable();
            $table->string('phone')->nullable();

            // Dossier Médical
            $table->text('medical_history')->nullable(); // Ex: Diabète Type 2 depuis 2010

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
