<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PersonalityType extends Model
{
    use HasFactory;

    /**
     * กำหนดชื่อของตารางในฐานข้อมูล
     *
     * @var string
     */
    protected $table = 'personality_types';

    /**
     * กำหนดฟิลด์ที่สามารถกรอกได้
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',         // ประเภทบุคลิกภาพ
        'description',  // คำอธิบายของประเภทบุคลิกภาพ
    ];

    /**
     * ความสัมพันธ์แบบ hasMany กับโมเดล `User`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class); // บุคลิกภาพหนึ่งประเภทสามารถมีผู้ใช้หลายคน
    }
}