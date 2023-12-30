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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('image')->nullable();
            $table->integer('role')->nullable()->default(3);            
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status')->nullable();
            $table->tinyInteger('is_deleted')->nullable()->default(0);
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pincode')->nullable();
            $table->string('admission_no')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('rollno')->nullable();
            $table->integer('class_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('gender')->nullable();
            $table->date('dob')->nullable();
            $table->string('caste')->nullable();
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('occupation')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
