<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Réserver une salle
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store') }}">
                        @csrf

                        <div class="mb-6">
                            <label for="salle_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Salle</label>
                            <select id="salle_id" name="salle_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                                <option value="">Sélectionner une salle</option>
                                @foreach($salles as $salle)
                                    <option value="{{ $salle->id }}" {{ old('salle_id', request('salle_id')) == $salle->id ? 'selected' : '' }}>
                                        {{ $salle->nom }} ({{ $salle->capacite }} pers. - {{ $salle->surface }} m²)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-6">
                            <label for="date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Date</label>
                            <input type="date" id="date" name="date"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ old('date', request('date', now()->toDateString())) }}" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="heure_debut" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Heure de début</label>
                                <input type="time" id="heure_debut" name="heure_debut"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ old('heure_debut', '09:00') }}" required>
                            </div>

                            <div>
                                <label for="heure_fin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Heure de fin</label>
                                <input type="time" id="heure_fin" name="heure_fin"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ old('heure_fin', '10:00') }}" required>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="titre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Titre de la réservation</label>
                            <input type="text" id="titre" name="titre"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ old('titre') }}" required>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description (optionnelle)</label>
                            <textarea id="description" name="description" rows="3"
                                     class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-6">
                            <button type="button" id="check-disponibilite" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                Vérifier disponibilité
                            </button>
                            <span id="disponibilite-result" class="ml-3"></span>
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('disponibilites.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Annuler</a>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Réserver</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkBtn = document.getElementById('check-disponibilite');

            checkBtn.addEventListener('click', function() {
                const salleId = document.getElementById('salle_id').value;
                const date = document.getElementById('date').value;
                const heureDebut = document.getElementById('heure_debut').value;
                const heureFin = document.getElementById('heure_fin').value;
                const resultElement = document.getElementById('disponibilite-result');

                if (!salleId || !date || !heureDebut || !heureFin) {
                    resultElement.textContent = 'Veuillez remplir tous les champs requis';
                    resultElement.className = 'ml-3 text-red-500';
                    return;
                }

                resultElement.textContent = 'Vérification en cours...';
                resultElement.className = 'ml-3 text-blue-500';

                fetch('{{ route('disponibilites.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        salle_id: salleId,
                        date: date,
                        heure_debut: heureDebut,
                        heure_fin: heureFin
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.disponible) {
                        resultElement.textContent = 'Salle disponible pour ce créneau !';
                        resultElement.className = 'ml-3 dark:text-green-400 text-green-400';
                    } else {
                        resultElement.textContent = 'Salle déjà réservée pour ce créneau !';
                        resultElement.className = 'ml-3 text-red-500';
                    }
                })
                .catch(error => {
                    resultElement.textContent = 'Erreur lors de la vérification';
                    resultElement.className = 'ml-3 text-red-500';
                    console.error('Erreur:', error);
                });
            });
        });
    </script>
</x-app-layout>
