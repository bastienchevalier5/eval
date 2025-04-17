<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Liste des salles
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('salles.create') }}"
                       class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Ajouter une salle
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 dark:border-gray-700 text-center">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="px-4 py-2 border">Nom</th>
                                <th class="px-4 py-2 border">Capacité</th>
                                <th class="px-4 py-2 border">Surface</th>
                                @if (Auth::user()->isAn('admin'))
                                    <th class="px-4 py-2 border">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="text-white bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach ($salles as $salle)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $salle->nom }}</td>
                                    <td class="px-4 py-2 border">{{ $salle->capacite }} places</td>
                                    <td class="px-4 py-2 border">{{ $salle->surface }} m²</td>
                                    @if (Auth::user()->isAn('admin'))
                                        <td class="px-4 py-2 border space-x-2">
                                            <a href="{{ route('salles.edit', $salle->id) }}"
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                                Modifier
                                            </a>

                                            <form method="POST" action="{{ route('salles.destroy', $salle->id) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette salle?')"
                                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
