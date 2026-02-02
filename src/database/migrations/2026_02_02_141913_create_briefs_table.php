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
        Schema::create('briefs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->date('start_date');
            $table->date('end_date');
            $table->text('content');
            $table->string('type');
            
            $table->foreignId('instructor_id')->constrained('users')->onDelete('set null');
            $table->foreignId('sprint_id')->constrained('sprints')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('briefs');
    }
};
