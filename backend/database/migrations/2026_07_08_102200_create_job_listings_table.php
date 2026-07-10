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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();

$table->foreignId('company_id')
    ->constrained()
    ->cascadeOnDelete();

$table->foreignId('category_id')
    ->constrained()
    ->cascadeOnDelete();

$table->string('title',150);

$table->text('description');

$table->string('employment_type',50);

$table->string('experience_level',50);

$table->decimal('salary_min',10,2)->nullable();
$table->decimal('salary_max',10,2)->nullable();

$table->string('country',100);
$table->string('city',100);

$table->boolean('is_remote')->default(false);

$table->date('application_deadline')->nullable();

$table->string('status',20)->default('draft');

$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
