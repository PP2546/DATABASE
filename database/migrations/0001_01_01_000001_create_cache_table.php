<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * รันการมิเกรชันเพื่อสร้างตารางในฐานข้อมูล
     */
    public function up(): void
    {
        // สร้างตาราง `cache` สำหรับเก็บข้อมูลแคช
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // คีย์หลักสำหรับแคช
            $table->mediumText('value'); // ข้อมูลแคช
            $table->integer('expiration'); // เวลาในการหมดอายุของแคช (เป็น UNIX timestamp)
        });

        // สร้างตาราง `cache_locks` สำหรับเก็บข้อมูลล็อกของแคช
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // คีย์หลักสำหรับล็อก
            $table->string('owner'); // เจ้าของล็อก (ระบุว่าใครเป็นเจ้าของล็อก)
            $table->integer('expiration'); // เวลาในการหมดอายุของล็อก (เป็น UNIX timestamp)
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('cache'); // ลบตาราง `cache` หากมีอยู่
        Schema::dropIfExists('cache_locks'); // ลบตาราง `cache_locks` หากมีอยู่
    }
};