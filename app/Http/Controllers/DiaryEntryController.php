<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DiaryEntry;
use Illuminate\Support\Facades\Auth;
use App\Models\Emotion;
use Illuminate\Support\Facades\DB;

class DiaryEntryController extends Controller
{
    /**
     * แสดงรายการบันทึกทั้งหมดของผู้ใช้ที่เข้าสู่ระบบ
     */
    public function index()
    {
        // Get the paginated diary entries with their associated emotions
        $diaryEntries = Auth::user()->diaryEntries()->with('emotions')->paginate(3);
        // Get the logged-in user ID
        $userId = Auth::id();
        // Count how many diaries are related to each emotion
        $emotionCounts = DB::table('diary_entry_emotions as dee')
            ->join('diary_entries as de', 'dee.diary_entry_id', '=', 'de.id')
            ->select('dee.emotion_id', DB::raw('count(dee.diary_entry_id) as diary_count'))
            ->where('de.user_id', $userId)
            ->whereIn('dee.emotion_id', [1, 2, 3, 4, 5])
            ->groupBy('dee.emotion_id')
            ->get();
        // Convert the data into a format suitable for display
        $summary = [];
        foreach ($emotionCounts as $count) {
        $summary[$count->emotion_id] = $count->diary_count;
    }
    // Return the view with both diary entries and summary data
        return view('diary.index', compact('diaryEntries', 'summary'));
    }

    /**
     * แสดงฟอร์มสำหรับการสร้างบันทึกใหม่
     */
    public function create()
    {
        $emotions = Emotion::all(); // ดึงอารมณ์ทั้งหมดสำหรับการเลือก
        return view('diary.create', compact('emotions')); // ส่งอารมณ์ไปยังมุมมอง
    }

    /**
     * บันทึกข้อมูลบันทึกใหม่ลงในฐานข้อมูล
     */
    public function store(Request $request)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'required|string',
            'emotions' => 'array', // ตรวจสอบอารมณ์เป็นอาร์เรย์
            'intensity' => 'array', // ตรวจสอบความเข้มข้นเป็นอาร์เรย์
        ]);

        // สร้างบันทึกใหม่
        $diaryEntry = Auth::user()->diaryEntries()->create([
            'date' => $validated['date'],
            'content' => $validated['content'],
        ]);

        // จัดการกับอารมณ์และความเข้มข้น
        if (!empty($validated['emotions']) && !empty($validated['intensity'])) {
            foreach ($validated['emotions'] as $emotionId) {
                $intensity = $validated['intensity'][$emotionId] ?? null;
                // เชื่อมต่ออารมณ์และความเข้มข้นกับบันทึก
                $diaryEntry->emotions()->attach($emotionId, ['intensity' => $intensity]);
            }
        }

        return redirect()->route('diary.index')->with('status', 'Diary entry added successfully!');
    }

    /**
     * แสดงรายละเอียดของบันทึกที่ระบุ
     */
    public function show(string $id)
    {
        $diaryEntry = Auth::user()->diaryEntries()->findOrFail($id);
        return view('diary.show', compact('diaryEntry'));
    }

    /**
     * แสดงฟอร์มสำหรับการแก้ไขบันทึกที่ระบุ
     */
    public function edit(string $id)
    {
        $diaryEntry = Auth::user()->diaryEntries()->with('emotions')->findOrFail($id);
        $emotions = Emotion::all(); // ดึงอารมณ์ทั้งหมด
        return view('diary.edit', compact('diaryEntry', 'emotions'));
    }

    /**
     * อัพเดตข้อมูลของบันทึกที่ระบุในฐานข้อมูล
     */
    public function update(Request $request, string $id)
    {
        // ตรวจสอบความถูกต้องของข้อมูลที่ส่งมา
        $validated = $request->validate([
            'date' => 'required|date',
            'content' => 'required|string',
            'emotions' => 'array', // ตรวจสอบอารมณ์เป็นอาร์เรย์
            'intensity' => 'array', // ตรวจสอบความเข้มข้นเป็นอาร์เรย์
        ]);

        // ค้นหาและอัพเดตบันทึก
        $diaryEntry = Auth::user()->diaryEntries()->findOrFail($id);
        $diaryEntry->update([
            'date' => $validated['date'],
            'content' => $validated['content'],
        ]);

        // ซิงค์อารมณ์และความเข้มข้น
        if (!empty($validated['emotions'])) {
            $emotions = [];
            foreach ($validated['emotions'] as $emotionId) {
                $intensity = $validated['intensity'][$emotionId] ?? null;
                $emotions[$emotionId] = ['intensity' => $intensity];
            }
            $diaryEntry->emotions()->sync($emotions);
        } else {
            // หากไม่มีอารมณ์ถูกเลือก ให้ลบอารมณ์ทั้งหมดที่เกี่ยวข้อง
            $diaryEntry->emotions()->sync([]);
        }

        return redirect()->route('diary.index')->with('status', 'Diary entry updated successfully!');
    }

    /**
     * ลบบันทึกที่ระบุออกจากฐานข้อมูล
     */
    public function destroy(string $id)
    {
        // ดึงบันทึกตาม ID
        $diaryEntry = Auth::user()->diaryEntries()->findOrFail($id);

        // ลบบันทึกที่ดึงออกมา
        $diaryEntry->delete();

        // เปลี่ยนเส้นทางกลับไปยังรายการบันทึกด้วยข้อความความสำเร็จ
        return redirect()->route('diary.index')->with('status', 'Diary entry deleted successfully!');
    }
}