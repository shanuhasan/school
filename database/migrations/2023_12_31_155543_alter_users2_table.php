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
        Schema::table('users',function(Blueprint $table){
            $table->string('marital_status')->nullable()->after('father_name');
            $table->string('qualification')->nullable()->after('marital_status');
            $table->string('work_experience')->nullable()->after('qualification');
            $table->string('note')->nullable()->after('work_experience');
            $table->longText('permanent_address')->nullable()->after('pincode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('marital_status');
            $table->dropColumn('qualification');
            $table->dropColumn('work_experience');
            $table->dropColumn('note');
            $table->dropColumn('permanent_address');
        });
    }
};
