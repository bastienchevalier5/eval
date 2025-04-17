<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Détails de la réservation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('reservations.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                            <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                            </svg>
                            Mes réservations
                        </a>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Détails</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $reservation->titre }}
                        </h3>

                        @if($reservation->heure_debut->isFuture())
                            <form action="{{ route('reservations.destroy', $reservation) }}" method="POST"
                                  onsubmit="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Annuler la réservation
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informations de réservation</h3>
                            <div class="overflow-x-auto relative">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Date :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->heure_debut->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Heure de début :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->heure_debut->format('H:i') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Heure de fin :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->heure_fin->format('H:i') }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Durée :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->heure_debut->diffInMinutes($reservation->heure_fin) / 60 }} heure(s)
                                            </td>
                                        </tr>
                                        <tr class="bg-white dark:bg-gray-800">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Statut :
                                            </th>
                                            <td class="py-3 px-6">
                                                @if($reservation->heure_debut->isFuture())
                                                    <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                        À venir
                                                    </span>
                                                @elseif($reservation->heure_fin->isPast())
                                                    <span class="bg-gray-100 text-gray-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                                        Terminée
                                                    </span>
                                                @else
                                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                                        En cours
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informations de la salle</h3>
                            <div class="overflow-x-auto relative">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Nom :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->salle->nom }}
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Capacité :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->salle->capacite }} places
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                            <th scope="row" class="py-3 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                Surface :
                                            </th>
                                            <td class="py-3 px-6">
                                                {{ $reservation->salle->surface }} m²
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @if($reservation->description)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h3>Description</h3>
                                    <div class="card">
                                        <div class="card-body">
                                            {{ $reservation->description }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="{{ route('reservations.index') }}" class="btn btn-outline-secondary">Retour à la liste</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
