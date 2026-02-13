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
        Schema::create('classroom_instructor', function (Blueprint $table) {
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
        });

        Schema::create('classroom_sprint', function (Blueprint $table) {
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->foreignId('sprint_id')->constrained()->onDelete('cascade');
        });

        Schema::create('brief_competence', function (Blueprint $table) {
            $table->foreignId('brief_id')->constrained()->onDelete('cascade');
            $table->foreignId('competence_id')->constrained()->onDelete('cascade');
            $table->enum('level', ['imiter', 's_adapter', 'transposer'])->nullable();
        });

        Schema::create('competence_debriefing', function (Blueprint $table) {
            $table->foreignId('competence_id')->constrained()->onDelete('cascade');
            $table->foreignId('debriefing_id')->constrained()->onDelete('cascade');
            $table->enum('level', ['imiter', 's_adapter', 'transposer'])->nullable();
            $table->enum('validate', ['valide', 'non_valide', 'pending'])->nullable()->default(null);
        });    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_instructor');
        Schema::dropIfExists('classroom_sprint');
        Schema::dropIfExists('brief_competence');
        Schema::dropIfExists('competence_debriefing');
    }
};
