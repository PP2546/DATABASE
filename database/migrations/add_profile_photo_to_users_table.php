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
            $table->string('profile_photo')->nullable(); // เพิ่มคอลัมน์ profile_photo ที่เป็นประเภท string และอนุญาตให้เป็นค่า null
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบคอลัมน์
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo'); // ลบคอลัมน์ profile_photo ออก
        });
    }
};