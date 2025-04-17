<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{Auth::user()->isAn('employe') ? 'Mes réservations' : 'Statistiques de résérvations'}}
            </h2>
            @if (Auth::user()->isAn('employe'))
                <a href="{{ route('reservations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Nouvelle réservation
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if(Auth::user()->isAn('employe'))
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="reservationTabs" role="tablist">
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-blue-600 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 active"
                                            id="upcoming-tab"
                                            data-tabs-target="#upcoming"
                                            type="button"
                                            role="tab"
                                            aria-controls="upcoming"
                                            aria-selected="true">
                                        À venir
                                    </button>
                                </li>
                                <li class="mr-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                            id="past-tab"
                                            data-tabs-target="#past"
                                            type="button"
                                            role="tab"
                                            aria-controls="past"
                                            aria-selected="false">
                                        Passées
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div id="reservationTabsContent">
                            <div class="block" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                <div class="overflow-x-auto relative">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="py-3 px-6">Salle</th>
                                                <th scope="col" class="py-3 px-6">Date</th>
                                                <th scope="col" class="py-3 px-6">Horaire</th>
                                                <th scope="col" class="py-3 px-6">Titre</th>
                                                <th scope="col" class="py-3 px-6">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $upcomingReservations = $reservations->filter(function($reservation) {
                                                    return $reservation->heure_fin->isFuture();
                                                })->sortBy('heure_debut');
                                            @endphp

                                            @forelse($upcomingReservations as $reservation)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td class="py-4 px-6">{{ $reservation->salle->nom }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->heure_debut->format('d/m/Y') }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->heure_debut->format('H:i') }} - {{ $reservation->heure_fin->format('H:i') }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->titre }}</td>
                                                    <td class="py-4 px-6">
                                                        <div class="flex items-center space-x-2">
                                                            <a href="{{ route('reservations.show', $reservation) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                                Détails
                                                            </a>
                                                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                                                onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                                                    Annuler
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td colspan="5" class="py-4 px-6 text-center">Aucune réservation à venir</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="hidden" id="past" role="tabpanel" aria-labelledby="past-tab">
                                <div class="overflow-x-auto relative">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="py-3 px-6">Salle</th>
                                                <th scope="col" class="py-3 px-6">Date</th>
                                                <th scope="col" class="py-3 px-6">Horaire</th>
                                                <th scope="col" class="py-3 px-6">Titre</th>
                                                <th scope="col" class="py-3 px-6">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $pastReservations = $reservations->filter(function($reservation) {
                                                    return $reservation->heure_fin->isPast();
                                                })->sortByDesc('heure_debut');
                                            @endphp

                                            @forelse($pastReservations as $reservation)
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td class="py-4 px-6">{{ $reservation->salle->nom }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->heure_debut->format('d/m/Y') }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->heure_debut->format('H:i') }} - {{ $reservation->heure_fin->format('H:i') }}</td>
                                                    <td class="py-4 px-6">{{ $reservation->titre }}</td>
                                                    <td class="py-4 px-6">
                                                        <a href="{{ route('reservations.show', $reservation) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                                            Détails
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                    <td colspan="5" class="py-4 px-6 text-center">Aucune réservation passée</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @elseif (Auth::user()->isAn('admin'))
                        <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-white">Taux de réservation des salles (6 dernières semaines)</h3>

                        <canvas id="reservationChart" height="100"></canvas>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            const ctx = document.getElementById('reservationChart').getContext('2d');
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: {!! json_encode($weeks->pluck('label')) !!},
                                    datasets: [{
                                        label: 'Taux de réservation (%)',
                                        data: {!! json_encode($weeks->pluck('taux')) !!},
                                        backgroundColor: 'rgba(59, 130, 246, 0.6)',
                                        borderColor: 'rgba(59, 130, 246, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 100,
                                            title: {
                                                display: true,
                                                text: 'Taux (%)'
                                            }
                                        }
                                    }
                                }
                            });
                        </script>

                        <div class="mt-6">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Semaine</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Réservations</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Créneaux dispo</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Taux (%)</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($weeks as $week)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $week['label'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $week['total_reservations'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $week['total_slots'] }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $week['taux'] }} %</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabsContainer = document.getElementById('reservationTabs');
            const tabs = tabsContainer.querySelectorAll('button[role="tab"]');
            const tabPanels = document.querySelectorAll('#reservationTabsContent > div');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Désactiver tous les onglets
                    tabs.forEach(t => {
                        t.classList.remove('border-blue-600', 'active');
                        t.classList.add('border-transparent');
                        t.setAttribute('aria-selected', 'false');
                    });

                    // Masquer tous les panneaux
                    tabPanels.forEach(panel => {
                        panel.classList.add('hidden');
                        panel.classList.remove('block');
                    });

                    // Activer l'onglet cliqué
                    tab.classList.remove('border-transparent');
                    tab.classList.add('border-blue-600', 'active');
                    tab.setAttribute('aria-selected', 'true');

                    // Afficher le panneau correspondant
                    const panelId = tab.getAttribute('data-tabs-target').substring(1);
                    const panel = document.getElementById(panelId);
                    panel.classList.remove('hidden');
                    panel.classList.add('block');
                });
            });
        });
    </script>
</x-app-layout>
