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
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('household_no')->nullable();

            $table->foreignId('house_hold_id')->nullable()->constrained('house_holds')->onDelete('set null');
            $table->string('firstname');
            $table->string('middlename')->nullable();
            $table->string('lastname');
            $table->string('alias')->nullable();
            $table->date('birthday');
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female']);
            $table->enum('civil_status', ['Single', 'Married', 'Divorced', 'Widowed']);
            $table->enum('voter_status', ['Registered', 'Not Registered']);
            $table->string('birth_of_place')->nullable();
            $table->string('citizenship')->default('Filipino');
            $table->string('mobile_no')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('email')->nullable();
            $table->string('father')->nullable();
            $table->string('mother')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};
