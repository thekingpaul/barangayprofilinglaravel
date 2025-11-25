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
        Schema::create('house_holds', function (Blueprint $table) {
            $table->id();
            $table->string('household_no')->unique(); // unique household number
            $table->string('household_head')->nullable();
            $table->string('purok'); // zone/sitio/purok
            $table->text('address'); // full address of the household
            $table->enum('house_ownership', ['Owned', 'Rented', 'Shared', 'Informal Settler']);
            $table->enum('house_type', ['Concrete', 'Semi-Concrete', 'Light Materials']);
            $table->boolean('electricity')->default(false); // yes/no
            $table->decimal('monthly_income', 10, 2)->nullable(); // total household income
            $table->string('livelihood')->nullable(); // primary source of income
            $table->json('beneficiaries')->nullable(); // 4Ps, PhilHealth, etc. (stored as JSON array)
            $table->json('disaster_risk')->nullable(); // flood-prone, coastal, etc. (stored as JSON array)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_holds');
    }
};
