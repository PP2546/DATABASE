<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * แสดงฟอร์มแก้ไขโปรไฟล์ของผู้ใช้
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * อัพเดตข้อมูลโปรไฟล์ของผู้ใช้
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        // หากอีเมลถูกแก้ไข ให้ตั้งค่าสถานะการยืนยันอีเมลเป็น null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated');
    }

    /**
     * ลบบัญชีผู้ใช้
     */
    public function destroy(Request $request): RedirectResponse
    {
        // ตรวจสอบรหัสผ่านของผู้ใช้ก่อนลบบัญชี
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // ออกจากระบบและลบบัญชีผู้ใช้
        Auth::logout();
        $user->delete();

        // ยกเลิกเซสชันและสร้างโทเค็นใหม่
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}