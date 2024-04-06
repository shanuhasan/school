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
        Schema::table('mark_registers', function (Blueprint $table) {
            $table->string('marks')->nullable()->after('exam');
            $table->string('passing_marks')->nullable()->after('marks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mark_registers', function (Blueprint $table) {
            $table->dropColumn('marks');
            $table->dropColumn('passing_marks');
        });
    }
};
