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
        Schema::create('emotions', function (Blueprint $table) {
            $table->id(); // คอลัมน์ id เป็นคีย์หลักและจะเพิ่มค่าโดยอัตโนมัติ
            $table->string('name'); // คอลัมน์ name ใช้เก็บชื่อของอารมณ์
            $table->text('description')->nullable(); // คอลัมน์ description ใช้เก็บคำอธิบายของอารมณ์ (อาจเป็นค่าว่างได้)
            $table->timestamps(); // คอลัมน์ created_at และ updated_at
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('emotions');
    }
};