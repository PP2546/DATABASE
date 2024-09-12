<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * รันการมิเกรชันเพื่อเพิ่มคอลัมน์
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('birthdate')->nullable()->after('email_verified_at');
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบคอลัมน์
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('birthdate');
        });
    }
};