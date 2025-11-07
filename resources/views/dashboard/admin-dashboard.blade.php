<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden sm:rounded-lg">
                <div class="p-6 text-black">
                    {{ __("You're logged in!") }}
                    <h1 class="text-2xl font-bold mt-2">Admin Dashboard</h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
