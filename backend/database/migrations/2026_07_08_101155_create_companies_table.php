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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

$table->string('name',150);
$table->string('email')->unique();
$table->string('phone',30);

$table->string('website')->nullable();
$table->string('logo_path')->nullable();

$table->string('industry',100);
$table->string('company_size',50);

$table->string('country',100);
$table->string('city',100);
$table->string('address');

$table->text('description')->nullable();

$table->string('status',20)->default('pending');

$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
