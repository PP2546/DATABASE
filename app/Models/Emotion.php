<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emotion extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางที่ใช้ในฐานข้อมูล
    protected $table = 'emotions';

    // กำหนดฟิลด์ที่สามารถกรอกได้
    protected $fillable = [
        'name',
        'description',
    ];

    // กำหนดการแปลงประเภทข้อมูล
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ความสัมพันธ์แบบ belongsToMany กับบันทึกไดอารี่
     */
    public function diaryEntries()
    {
        return $this->belongsToMany(DiaryEntry::class, 'diary_entry_emotions')
            ->withPivot('intensity') // การจัดการกับฟิลด์ที่อยู่ในตารางกลาง
            ->withTimestamps(); // รวมเวลาในการสร้างและอัพเดตในตารางกลาง
    }
}