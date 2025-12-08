<x-app-layout>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-800 p-3 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="py-10 max-w-6xl mx-auto px-6">
        <div class="flex gap-8 items-start">

            @php
                $hasCourses = !empty(session('courses'));
            @endphp

            <!-- Lijeva strana: Informacije i upload -->
            <div class="w-[45%] bg-white border border-gray-200 rounded-xl shadow p-6 transition-all duration-300">
                <h2 class="text-xl font-semibold mb-4">Information</h2>

                <!-- Student -->
                <div class="flex flex-col gap-4 mb-6">
                    <label for="student_id" class="font-semibold">Student</label>
                    <div class="relative">
                        <input type="text" 
                            id="student_search" 
                            placeholder="Pretraži studenta..." 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            autocomplete="off">
                        
                        <div id="student_search_results" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                        </div>

                        <select id="student_id" name="student_id" class="hidden">
                            <option value="">-- Odaberite studenta --</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}"
                                    {{ old('student_id') == $student->id ? 'selected' : '' }}
                                    data-ime="{{ $student->ime }}"
                                    data-prezime="{{ $student->prezime }}"
                                    data-br_indexa="{{ $student->br_indexa }}">
                                    {{ $student->ime }} {{ $student->prezime }} ({{ $student->br_indexa }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Fakultet -->
                <div class="flex flex-col gap-4 mb-6">
                    <label for="fakultet_id" class="font-semibold">Fakultet</label>
                    <div class="relative">
                        <input type="text" 
                            id="fakultet_search" 
                            placeholder="Pretraži fakultet..." 
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            autocomplete="off">
                        
                        <div id="fakultet_search_results" class="absolute z-50 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                        </div>

                        <select id="fakultet_id" name="fakultet_id" class="hidden">
                            <option value="">-- Odaberite fakultet --</option>
                            @foreach($fakulteti as $fakultet)
                                @if($fakultet->naziv !== 'FIT')
                                    <option value="{{ $fakultet->id }}" 
                                        {{ old('fakultet_id') == $fakultet->id ? 'selected' : '' }}
                                        data-naziv="{{ $fakultet->naziv }}">
                                        {{ $fakultet->naziv }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Datumi -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="flex flex-col gap-2">
                        <label for="datum_pocetka" class="font-semibold">Datum početka</label>
                        <input type="date" id="datum_pocetka" name="datum_pocetka" 
                            value="{{ old('datum_pocetka') }}"
                            class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="datum_kraja" class="font-semibold">Datum kraja</label>
                        <input type="date" id="datum_kraja" name="datum_kraja" 
                            value="{{ old('datum_kraja') }}"
                            class="border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <!-- Subjects -->
                <h3 class="text-lg font-semibold mb-3">Subjects</h3>
                <div id="subjectList" class="subjects-container mb-3"></div>

                <!-- Upload form -->
                <form id="uploadForm" action="{{ route(auth()->user()->type === 0 ? 'admin.mobility.upload' : 'profesor.mobility.upload') }}" method="POST" enctype="multipart/form-data" class="add-subject flex items-center gap-2 mt-auto">
                    @csrf
                    <input type="hidden" name="ime" id="hiddenIme">
                    <input type="hidden" name="prezime" id="hiddenPrezime">
                    <input type="hidden" name="fakultet" id="hiddenFakultet">
                    <input type="hidden" name="broj_indeksa" id="hiddenBrojIndeksa">

                    <input type="file" name="word_file" accept=".doc,.docx" class="hidden" id="wordFileInput">
                    <button type="button" class="btn bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg" onclick="document.getElementById('wordFileInput').click()">
                        Upload ToR
                    </button>

                    <button type="button"
                        class="btn bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg"
                        id="exportButton">
                        Export Word
                    </button>

                    <button type="button"
                        class="btn bg-purple-600 hover:bg-purple-700 text-white font-semibold px-4 py-2 rounded-lg"
                        id="saveButton">
                        Save LA
                    </button>

                </form>

                @if($hasCourses)
                    <div class="grid gap-3 mt-6" id="uploadedSubjects">
                        @foreach(session('courses') as $course)
                            @php
                                $name = is_array($course)
                                ? ($course['Course'] ?? $course['Naziv'] ?? $course['name'] ?? $course['Subject'] ?? $course['Predmet'] ?? null)
                                : $course;
                            @endphp
                            @if(!empty($name))
                                <div class="uploaded-subject border border-gray-200 rounded-md bg-gray-50 px-4 py-2 hover:bg-gray-100 transition cursor-pointer" data-name="{{ $name }}">
                                    <div class="flex items-start justify-between gap-3">
                                        <span class="subject-title">{{ $name }}</span>
                                    </div>
                                    <div class="linked-pills mt-2 flex flex-wrap gap-2 text-sm"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Desna strana: Available subjects -->
            <div class="w-[55%] bg-white border border-gray-200 rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Available Subjects</h2>

                <!-- Dva kontejnera: FIT i ostali fakulteti -->
                <h3 class="font-semibold mb-2">Domaći univerzitet (FIT)</h3>
                <div id="domaciSubjects" class="flex flex-col gap-3 mb-4"></div>

                <h3 class="font-semibold mb-2">Strani univerzitet</h3>
                <div id="availableSubjects" class="flex flex-col gap-3"></div>
            </div>

        </div>
    </div>

    <script>
        const uploadedCourses = @json(session('courses', []));
        
        const fileInput = document.getElementById('wordFileInput');
        const form = document.getElementById('uploadForm');
        if (fileInput && form) {
            fileInput.addEventListener('change', () => {
                if (fileInput.files.length > 0) form.submit();
            });
        }

        const links = {};
        let activeLeft = null;
        const MAX_LINKS = 4;

        const leftCards = Array.from(document.querySelectorAll('.uploaded-subject'));
        const rightCards = refreshRightCards();

        const fakultetPredmeti = @json($fakulteti->filter(fn($f) => $f->naziv !== 'FIT')->mapWithKeys(fn($fak) => [$fak->id => $fak->predmeti->pluck('naziv')]));
        const fitPredmeti = @json($fakulteti->firstWhere('naziv', 'FIT')->predmeti->pluck('naziv'));

        const fakultetSelect = document.getElementById('fakultet_id');
        const availableSubjectsContainer = document.getElementById('availableSubjects');
        const domaciSubjectsContainer = document.getElementById('domaciSubjects');

        // Popuni FIT predmete odmah
        fitPredmeti.forEach(subject => {
            const div = document.createElement('div');
            div.className = 'available-subject border border-gray-200 px-4 py-2 rounded-md bg-gray-50 hover:bg-gray-100 transition cursor-pointer';
            div.dataset.name = subject;
            div.textContent = subject;
            div.addEventListener('click', () => toggleLink(div));
            domaciSubjectsContainer.appendChild(div);
        });

        fakultetSelect.addEventListener('change', () => {
            const fakultetId = fakultetSelect.value;
            availableSubjectsContainer.innerHTML = ''; 

            for (const key in links) delete links[key];
            document.querySelectorAll('.linked-pills').forEach(el => el.innerHTML = '');
            setActiveLeft(null);

            if (!fakultetId || !fakultetPredmeti[fakultetId]) return;

            fakultetPredmeti[fakultetId].forEach(subject => {
                const div = document.createElement('div');
                div.className = 'available-subject border border-gray-200 px-4 py-2 rounded-md bg-gray-50 hover:bg-gray-100 transition cursor-pointer';
                div.dataset.name = subject;
                div.textContent = subject;

                div.addEventListener('click', () => toggleLink(div));
                availableSubjectsContainer.appendChild(div);
            });
        });

        if (fakultetSelect.value) {
            fakultetSelect.dispatchEvent(new Event('change'));
        }

        function refreshRightCards() {
            return Array.from(document.querySelectorAll('.available-subject'));
        }

        // Funkcije toggle, setActiveLeft, renderPillsForLeft i ostalo ostaje isto
        // (kopirati kod iz prethodnih verzija koji radi povezivanje i export/save)
        // ...

        // Ostatak JS: search, save/export button, dodavanje hidden inputa itd.
        // Isto kao u prethodnom kodu koji ti radi, samo dodano da se FIT prikazuje od starta
    </script>

</x-app-layout>
