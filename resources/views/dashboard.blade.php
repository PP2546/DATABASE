<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-7 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl flex justify-center font-bold ">Hello, {{ Auth::user()->name }}!</h3>

                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" style="width: 180px; height: 180px;" class="rounded-full mx-auto mt-7">
                        @else
                            <img src="{{ asset('images/default_profile.png') }}" alt="Default Profile Photo" style="width: 180px; height: 180px;" class="rounded-full mx-auto mt-7">
                        @endif

                        <h3 class="text-300 flex justify-center  mt-7">HI , I'm IPHAT. I hope we get along!!!</h3>

                        <h5 class="text-xl flex justify-center  mt-7">You're logged in!</h5>
                 </div>
            </div>
        </div>
    </div>
</x-app-layout>
