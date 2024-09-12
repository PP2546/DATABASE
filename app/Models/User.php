<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * กำหนดฟิลด์ที่สามารถกรอกได้
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',              // ชื่อของผู้ใช้
        'email',             // อีเมลของผู้ใช้
        'password',          // รหัสผ่านของผู้ใช้
        'birthdate',         // วันเกิดของผู้ใช้
        'profile_photo',     // รูปโปรไฟล์ของผู้ใช้
    ];

    /**
     * กำหนดฟิลด์ที่ควรซ่อนเมื่อทำการ serialization
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',          // รหัสผ่าน (ควรซ่อนจากการแสดงผล)
        'remember_token',    // โทเค็นการจดจำ (ควรซ่อนจากการแสดงผล)
    ];

    /**
     * กำหนดการแปลงประเภทข้อมูล
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',   // แปลง `email_verified_at` เป็นประเภท `datetime`
            // 'password' => 'hashed',            // การแปลง `password` เป็น `hashed` ไม่จำเป็นในที่นี้
        ];
    }

    /**
     * ความสัมพันธ์แบบ hasOne กับโมเดล `UserBio`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bio(): HasOne
    {
        return $this->hasOne(UserBio::class, 'user_id'); // ผู้ใช้หนึ่งคนมีชีวประวัติหนึ่งรายการ
    }

    /**
     * ความสัมพันธ์แบบ belongsTo กับโมเดล `PersonalityType`
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function personalityTypes(): BelongsTo
    {
        return $this->belongsTo(PersonalityType::class); // ผู้ใช้หนึ่งคนมีบุคลิกภาพหนึ่งรายการ
    }

    /**
     * ความสัมพันธ์แบบ hasMany กับโมเดล `DiaryEntry`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function diaryEntries(): HasMany
    {
        return $this->hasMany(DiaryEntry::class); // ผู้ใช้หนึ่งคนมีบันทึกไดอารี่หลายรายการ
    }
}