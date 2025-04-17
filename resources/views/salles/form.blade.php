<x-app-layout>
    <x-slot name="header">
        <h2 class="text-center font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{$salle->exists ? 'Modification de la salle '. $salle->nom : 'Ajout d\'une salle'}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 text-center">
                    <x-form method="{{ $salle->exists ? 'PUT' : 'POST' }}" action="{{ $salle->exists ? route('salles.update', $salle->id) : route('salles.store') }}">
                        <x-input-label value="Nom de la salle" for="nom" />
                        <x-text-input id="nom" class="block m-5 w-50 mx-auto" type="text" name="nom" :value="old('nom', $salle->nom)" required autofocus autocomplete="nom" />

                        <x-input-label value="Capacité" for="capacite" />
                        <x-text-input id="capacite" class="block m-5 w-50 mx-auto" type="number" name="capacite" :value="old('capacite', $salle->capacite)" required autofocus autocomplete="capacite" />

                        <x-input-label value="Surface (en m²)" for="surface" />
                        <x-text-input id="surface" class="block m-5 w-50 mx-auto" type="number" name="surface" :value="old('surface', $salle->surface)" required autofocus autocomplete="surface" />

                        <x-button>
                            {{ $salle->exists ? 'Modifier' : 'Ajouter' }}
                        </x-button>
                    </x-form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
