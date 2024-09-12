<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiaryEntry extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางที่ใช้ในฐานข้อมูล
    protected $table = 'diary_entries';

    // กำหนดฟิลด์ที่สามารถกรอกได้
    protected $fillable = [
        'user_id',
        'date',
        'content',
    ];

    // กำหนดการแปลงประเภทข้อมูล
    protected $casts = [
        'date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ความสัมพันธ์แบบ belongsTo กับผู้ใช้
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * ความสัมพันธ์แบบ belongsToMany กับอารมณ์
     */
    public function emotions()
    {
        return $this->belongsToMany(Emotion::class, 'diary_entry_emotions', 'diary_entry_id', 'emotion_id')
            ->withPivot('intensity') // การจัดการกับฟิลด์ที่อยู่ในตารางกลาง
            ->withTimestamps(); // รวมเวลาในการสร้างและอัพเดตในตารางกลาง
    }
}