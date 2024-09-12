<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Bio & Personality Type') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">




                    <!-- แบบฟอร์มสำหรับแก้ไข Bio -->
                    <form method="post" action="{{ route('profile.update-bio') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('patch')

                        <div>
                            <!-- แสดง label สำหรับช่อง Bio -->
                            <x-input-label for="bio" :value="__('Bio Information')" />

                            <!-- ช่องสำหรับกรอก Bio -->
                            <textarea id="bio" name="bio" rows="5"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                required>{{ old('bio', $bio->bio ?? '') }}</textarea>

                            <!-- แสดงข้อผิดพลาดถ้ามีการกรอกข้อมูลผิด -->
                            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                        </div>




                        <!-- แบบฟอร์มสำหรับแก้ไขประเภทบุคลิกภาพ -->
                        <div>
                            <!-- แสดง label สำหรับช่อง Personality Type -->
                            <x-input-label for="personality_type" :value="__('Personality Type')" />

                            <!-- เลือกประเภทบุคลิกภาพจากรายการที่กำหนด -->
                            <select id="personality_type" name="personality_types_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-100"
                                required>
                                @foreach($personalityTypes as $type)
                                <!-- แสดงรายการประเภทบุคลิกภาพ -->
                                <option value="{{ $type->id }}"
                                    {{ $user->personality_types_id == $type->id ? 'selected' : '' }}>
                                    {{ $type->type }} ({{ $type->description}})
                                </option>
                                @endforeach
                            </select>

                            <!-- แสดงข้อผิดพลาดถ้ามีการกรอกข้อมูลผิด -->
                            <x-input-error class="mt-2" :messages="$errors->get('personality_types_id')" />
                        </div>




                        <!-- ปุ่มสำหรับบันทึกการแก้ไข -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update Bio & Personality') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JavaScript สำหรับแสดงข้อความแจ้งเตือน -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('status'))
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('
            status ') }}',
            confirmButtonText: 'OK'
        });
        @endif
    });
    </script>
</x-app-layout>