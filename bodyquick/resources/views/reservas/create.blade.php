<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reservar Sesión de Entrenamiento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('reservas.store') }}">
                @csrf

                <div class="mb-4">
                    <x-label for="fecha" value="Fecha" />
                    <x-input id="fecha" class="block mt-1 w-full" type="date" name="fecha" required />
                </div>

                <div class="mb-4">
                    <x-label for="hora" value="Hora" />
                    <x-input id="hora" class="block mt-1 w-full" type="time" name="hora" required />
                </div>

                <div class="mb-4">
                    <x-label for="tipo_sesion" value="Tipo de Sesión" />
                    <select id="tipo_sesion" name="tipo_sesion" class="block mt-1 w-full border-gray-300 rounded-md">
                        <option value="entrenamiento convencional">Entrenamiento Convencional</option>
                        <option value="entrenamiento con chaleco de electroestimulacion">Entrenamiento con Chaleco de Electroestimulacion</option>
                        <option value="readaptacion de lesiones">Readaptación de Lesiones</option>
                    </select>
                </div>

                <div>
                    <x-button>
                        Reservar
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>