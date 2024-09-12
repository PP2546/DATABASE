<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * รันการมิเกรชันเพื่อสร้างตาราง
     */
    public function up(): void
    {
        // สร้างตาราง DiaryEntries
        Schema::create('diary_entries', function (Blueprint $table) {
            $table->id(); // คอลัมน์ id เป็นคีย์หลักและจะเพิ่มค่าโดยอัตโนมัติ
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // คอลัมน์ user_id เป็น foreign key ที่เชื่อมโยงกับตาราง users
            $table->date('date'); // คอลัมน์ date ใช้เก็บวันที่
            $table->text('content'); // คอลัมน์ content ใช้เก็บเนื้อหาการบันทึก
            $table->timestamps(); // คอลัมน์ created_at และ updated_at
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entries');
    }
};