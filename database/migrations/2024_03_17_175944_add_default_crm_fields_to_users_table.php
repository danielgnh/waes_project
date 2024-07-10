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
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->nullable()->after('name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('salutation')->nullable()->after('last_name');
            $table->string('profile_image')->nullable();
            $table->string('phone')->nullable();
            $table->date('birthday')->nullable();
            $table->string('job_title')->nullable();
            // $table->string('company_id')->nullable();
            // $table->string('region_id')->nullable();

            // Other fields, system fields
            $table->boolean('is_system_user')->nullable();
            $table->boolean('is_customer')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('salutation');
            $table->dropColumn('profile_image');
            $table->dropColumn('phone');
            $table->dropColumn('birthday');
            $table->dropColumn('job_title');
            // $table->dropColumn('company_id');
            // $table->dropColumn('region_id');

            // Other fields, system fields
            $table->dropColumn('is_system_user');
            $table->dropColumn('is_customer');
            $table->dropSoftDeletes();
        });
    }
};
