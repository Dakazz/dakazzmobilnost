<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Studenti') }}
        </h2>
    </x-slot>

    <div class="py-10 max-w-7xl mx-auto px-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 mb-4 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Studenti</h1>
            <a href="{{ route('studenti.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg">
                Dodaj studenta
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">Lista studenata</h2>
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $studenti->total() }} Ukupno</span>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Broj indeksa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ime i prezime</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Godina studija</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivo studija</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Akcije</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($studenti as $student)
                            <tr class="hover:bg-gray-50 transition-colors duration-150 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->br_indexa }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $student->ime }} {{ $student->prezime }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->godina_studija }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->nivoStudija->naziv ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('studenti.edit', $student->id) }}" 
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1 rounded-md">
                                            Uredi
                                        </a>
                                        <form action="{{ route('studenti.destroy', $student->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Da li ste sigurni da želite da obrišete ovog studenta?')"
                                              class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white text-sm px-3 py-1 rounded-md">
                                                Obriši
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                    Nema studenata u bazi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $studenti->links() }}
        </div>
    </div>
</x-app-layout>
