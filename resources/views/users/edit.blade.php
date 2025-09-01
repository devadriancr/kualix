<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('users.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <!-- Mensajes de error generales -->
                        @if($errors->any())
                            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/10 border-l-4 border-red-500 text-red-700 dark:text-red-300">
                                <p class="font-medium">Por favor corrige los siguientes errores:</p>
                                <ul class="mt-2 list-disc list-inside text-sm">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-label for="name" :value="__('Nombre')" />
                                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)" required autofocus />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-label for="nickname" :value="__('Usuario')" />
                                <x-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname', $user->nickname)" required />
                                @error('nickname')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <x-label for="email" :value="__('Email')" />
                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $user->email)" required />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <x-label for="password" :value="__('Nueva Contraseña')" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Dejar en blanco para mantener la contraseña actual</p>
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <x-label for="password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                            </div>

                            <!-- Área -->
                            <div>
                                <x-label for="area_id" :value="__('Área')" />
                                <select id="area_id" name="area_id" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300">
                                    <option value="">Seleccione un área</option>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}" {{ old('area_id', $user->area_id) == $area->id ? 'selected' : '' }}>
                                            {{ $area->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('area_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Roles -->
                            <div class="md:col-span-2">
                                <x-label :value="__('Roles')" />
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                                    @foreach($roles as $role)
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5">
                                                <input id="role_{{ $role->id }}" name="roles[]" type="checkbox" value="{{ $role->id }}"
                                                    {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                    class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <label for="role_{{ $role->id }}" class="font-medium text-gray-700 dark:text-gray-300">{{ $role->name }}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @error('roles')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('users.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                Cancelar
                            </a>
                            <x-button>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                {{ __('Actualizar Usuario') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
