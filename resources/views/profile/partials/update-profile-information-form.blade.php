<section>
    <!-- ส่วนหัว (Header) -->
    <header>
        <!-- หัวข้อ -->
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <!-- คำอธิบาย -->
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- ฟอร์มการส่งการตรวจสอบอีเมล (Verification Email Form) -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- ฟอร์มการอัปเดตโปรไฟล์ -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- ช่องกรอกชื่อ -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- ช่องกรอกอีเมล -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            <!-- การตรวจสอบอีเมล -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!-- ข้อมูลชีวประวัติ -->
        <div class="mt-4">
            <h4 class="font-medium text-blue-900">
                {{ __('Bio Information') }}
            </h4>
            <p class="mt-2">
                {{ $user->bio->bio ?? 'No bio available' }}
            </p>
        </div>

        <!-- Personality Type Section -->
        <div class="mt-4">
            <h4 class="font-medium text-blue-900">
                {{ __('Personality Type') }}
            </h4>
            <p class="mt-2">
                @if ($user->personalityTypes)
            <div class="flex flex-col space-y-1">
                <p class="font-medium text-l">{{ $user->personalityTypes->type }}</p>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $user->personalityTypes->description }}</p>
            </div>
            @else
            <p class="font-medium text-l">{{ ('No personality type available') }}</p>
            @endif
            </p>
        </div>


        <!-- ปุ่มบันทึกและลิงก์จัดการชีวประวัติ -->
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            <a href="{{ route('profile.show-bio') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                {{ __('Click to Manage Bio') }}
            </a>
        </div>

        <!-- ข้อความสถานะหลังการบันทึก -->
        @if (session('status') === 'profile-updated')
        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
            class="text-sm text-gray-600 dark:text-gray-400">
            {{ __('Saved.') }}
        </p>
        @endif
    </form>
</section>