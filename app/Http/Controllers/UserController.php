<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\UserBio;
use App\Models\PersonalityType;

class UserController extends Controller
{
    /**
     * อัพเดตภาพโปรไฟล์ของผู้ใช้
     */
    public function updateProfilePhoto(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // ตรวจสอบและลบภาพโปรไฟล์เก่าถ้ามี
        if ($request->file('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // บันทึกภาพโปรไฟล์ใหม่
            $fileName = time() . '_' . $request->file('profile_photo')->getClientOriginalName();
            $filePath = $request->file('profile_photo')->storeAs('uploads/profile_photos', $fileName, 'public');

            $user->profile_photo = $filePath;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('status', 'profile-photo-updated');
    }

    /**
     * แสดงข้อมูลชีวประวัติของผู้ใช้
     */
    public function showBio()
    {
        $user = Auth::user();
        $bio = $user->bio;
        $personalityTypes = PersonalityType::all(); // ดึงข้อมูลประเภทบุคลิกภาพทั้งหมด

        return view('profile.show-bio', compact('user', 'bio', 'personalityTypes'));
    }

    /**
     * อัพเดตข้อมูลชีวประวัติของผู้ใช้
     */
    public function updateBio(Request $request)
    {
        $user = Auth::user();

        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $request->validate([
            'bio' => 'required|string',
            'personality_types_id' => 'nullable|exists:personality_types,id', // ตรวจสอบว่า personality_types_id อยู่ในตาราง personality_types
        ]);

        // อัพเดตหรือสร้างชีวประวัติ
        if ($user->bio) {
            $user->bio->update(['bio' => $request->input('bio')]);
        } else {
            $user->bio()->create(['bio' => $request->input('bio')]);
        }

        // อัพเดต personality type ถ้ามี
        if ($request->has('personality_types_id')) {
            $user->personality_types_id = $request->input('personality_types_id');
            $user->save();
        }

        return redirect()->route('profile.show-bio')->with('status', 'Bio and Personality updated successfully!');
    }
}