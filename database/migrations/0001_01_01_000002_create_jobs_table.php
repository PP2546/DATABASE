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
        // สร้างตาราง `jobs` สำหรับเก็บข้อมูลงานในคิว
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Primary key: auto-incrementing ID
            $table->string('queue')->index(); // คิวที่งานอยู่ (ทำดัชนีเพื่อเพิ่มประสิทธิภาพในการค้นหา)
            $table->longText('payload'); // ข้อมูลของงาน (เนื้อหาที่ต้องประมวลผล)
            $table->unsignedTinyInteger('attempts'); // จำนวนครั้งที่พยายามประมวลผลงาน
            $table->unsignedInteger('reserved_at')->nullable(); // เวลาเมื่อถูกจอง (เป็น UNIX timestamp)
            $table->unsignedInteger('available_at'); // เวลาเมื่อสามารถดำเนินการได้ (เป็น UNIX timestamp)
            $table->unsignedInteger('created_at'); // เวลาเมื่อสร้างงาน (เป็น UNIX timestamp)
        });

        // สร้างตาราง `job_batches` สำหรับเก็บข้อมูลกลุ่มงาน
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // Primary key: ID ของกลุ่มงาน
            $table->string('name'); // ชื่อของกลุ่มงาน
            $table->integer('total_jobs'); // จำนวนงานทั้งหมดในกลุ่ม
            $table->integer('pending_jobs'); // จำนวนงานที่ยังรออยู่
            $table->integer('failed_jobs'); // จำนวนงานที่ล้มเหลว
            $table->longText('failed_job_ids'); // รายการของ ID งานที่ล้มเหลว
            $table->mediumText('options')->nullable(); // ตัวเลือกเพิ่มเติม (สามารถเป็น NULL ได้)
            $table->integer('cancelled_at')->nullable(); // เวลาเมื่อกลุ่มงานถูกยกเลิก (เป็น UNIX timestamp, สามารถเป็น NULL ได้)
            $table->integer('created_at'); // เวลาเมื่อสร้างกลุ่มงาน (เป็น UNIX timestamp)
            $table->integer('finished_at')->nullable(); // เวลาเมื่อกลุ่มงานเสร็จสิ้น (เป็น UNIX timestamp, สามารถเป็น NULL ได้)
        });

        // สร้างตาราง `failed_jobs` สำหรับเก็บข้อมูลงานที่ล้มเหลว
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Primary key: auto-incrementing ID
            $table->string('uuid')->unique(); // UUID ที่ไม่ซ้ำกันสำหรับงานที่ล้มเหลว
            $table->text('connection'); // ข้อมูลการเชื่อมต่อที่ใช้สำหรับงาน
            $table->text('queue'); // คิวที่งานอยู่
            $table->longText('payload'); // ข้อมูลของงานที่ล้มเหลว
            $table->longText('exception'); // ข้อมูลข้อผิดพลาดที่เกิดขึ้น
            $table->timestamp('failed_at')->useCurrent(); // เวลาเมื่อเกิดความล้มเหลว (ใช้เวลาปัจจุบันเป็นค่าเริ่มต้น)
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs'); // ลบตาราง `jobs` หากมีอยู่
        Schema::dropIfExists('job_batches'); // ลบตาราง `job_batches` หากมีอยู่
        Schema::dropIfExists('failed_jobs'); // ลบตาราง `failed_jobs` หากมีอยู่
    }
};