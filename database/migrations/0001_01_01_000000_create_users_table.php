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
        // สร้างตาราง `users` สำหรับเก็บข้อมูลผู้ใช้
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Primary key: auto-incrementing ID
            $table->string('name'); // ชื่อของผู้ใช้
            $table->string('email')->unique(); // อีเมลของผู้ใช้ (ต้องไม่ซ้ำกัน)
            $table->timestamp('email_verified_at')->nullable(); // เวลาในการตรวจสอบอีเมล (สามารถเป็น NULL ได้)
            $table->string('password'); // รหัสผ่านของผู้ใช้
            $table->rememberToken(); // โทเค็นการจดจำ (ใช้ในการเข้าสู่ระบบอัตโนมัติ)
            $table->timestamps(); // ฟิลด์สำหรับติดตามเวลาการสร้างและแก้ไข
        });

        // สร้างตาราง `password_reset_tokens` สำหรับเก็บข้อมูลโทเค็นการรีเซ็ตรหัสผ่าน
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // อีเมลของผู้ใช้ (เป็นคีย์หลัก)
            $table->string('token'); // โทเค็นการรีเซ็ตรหัสผ่าน
            $table->timestamp('created_at')->nullable(); // เวลาในการสร้างโทเค็น (สามารถเป็น NULL ได้)
        });

        // สร้างตาราง `sessions` สำหรับเก็บข้อมูลเซสชันของผู้ใช้
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID ของเซสชัน (เป็นคีย์หลัก)
            $table->foreignId('user_id')->nullable()->index(); // Foreign key ไปยังตาราง `users` (สามารถเป็น NULL ได้)
            $table->string('ip_address', 45)->nullable(); // ที่อยู่ IP ของผู้ใช้ (สามารถเป็น NULL ได้)
            $table->text('user_agent')->nullable(); // ข้อมูล user agent (สามารถเป็น NULL ได้)
            $table->longText('payload'); // ข้อมูลของเซสชัน (บันทึกข้อมูลการเซสชันทั้งหมด)
            $table->integer('last_activity')->index(); // เวลาสุดท้ายที่มีการทำกิจกรรมในเซสชัน (ทำดัชนีเพื่อเพิ่มประสิทธิภาพ)
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('users'); // ลบตาราง `users` หากมีอยู่
        Schema::dropIfExists('password_reset_tokens'); // ลบตาราง `password_reset_tokens` หากมีอยู่
        Schema::dropIfExists('sessions'); // ลบตาราง `sessions` หากมีอยู่
    }
};