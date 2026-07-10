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
        Schema::create('educations', function (Blueprint $table) {
            $table->id();

$table->foreignId('candidate_profile_id')
    ->constrained()
    ->cascadeOnDelete();

$table->string('institution',150);

$table->string('degree',100);

$table->string('field_of_study',100);

$table->date('start_date');

$table->date('end_date')->nullable();

$table->decimal('grade',4,2)->nullable();

$table->text('description')->nullable();

$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
