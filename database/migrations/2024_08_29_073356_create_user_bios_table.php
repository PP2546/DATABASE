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
        Schema::create('user_bios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unique(); // คอลัมน์ user_id ต้องไม่ซ้ำ
            $table->text('bio')->nullable(); // คอลัมน์ bio สามารถเป็น NULL ได้
            $table->timestamps(); // คอลัมน์ created_at และ updated_at
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // การสร้าง foreign key และการตั้งค่า onDelete
        });
    }

    /**
     * ย้อนกลับการมิเกรชันเพื่อทำการลบตาราง
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bios');
    }
};