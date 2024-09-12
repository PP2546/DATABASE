<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBio extends Model
{
    use HasFactory;

    // กำหนดชื่อตารางที่ใช้ในฐานข้อมูล
    protected $table = 'user_bios';

    // กำหนดฟิลด์ที่สามารถกรอกได้
    protected $fillable = [
        'user_id',
        'bio',
    ];

    // กำหนดการแปลงประเภทข้อมูล
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * ความสัมพันธ์แบบ belongsTo กับผู้ใช้
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}