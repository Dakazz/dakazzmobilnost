<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uredi studenta') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-6">
            <a href="{{ route('studenti.index') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                &larr; Nazad na listu studenata
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h1 class="text-2xl font-semibold text-gray-800">Uredi: {{ $student->ime }} {{ $student->prezime }}</h1>
            </div>

            <div class="p-6">
                @include('studenti._form', ['student' => $student, 'nivoiStudija' => $nivoiStudija])
            </div>
        </div>
    </div>
</x-app-layout>
