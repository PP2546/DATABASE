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
        Schema::create('diary_entry_emotions', function (Blueprint $table) {
            $table->id(); // สร้างคอลัมน์ id เป็นคีย์หลักและจะเพิ่มค่าโดยอัตโนมัติ
            $table->foreignId('diary_entry_id')
                ->constrained('diary_entries') // ตั้งค่า foreign key ให้เชื่อมกับตาราง diary_entries
                ->onDelete('cascade'); // ลบข้อมูลในตารางนี้เมื่อข้อมูลที่เกี่ยวข้องในตาราง diary_entries ถูกลบ
            $table->foreignId('emotion_id')
                ->constrained('emotions') // ตั้งค่า foreign key ให้เชื่อมกับตาราง emotions
                ->onDelete('cascade'); // ลบข้อมูลในตารางนี้เมื่อข้อมูลที่เกี่ยวข้องในตาราง emotions ถูกลบ
            $table->integer('intensity'); // คอลัมน์ intensity ใช้เก็บค่าความเข้มข้นของอารมณ์ (เช่น จาก 1 ถึง 10)
            $table->timestamps(); // คอลัมน์ created_at และ updated_at
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('diary_entry_emotions');
    }
};