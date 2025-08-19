<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Crear Nuevo Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

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
                            <div class="mb-4">
                                <x-label for="name" value="Nombre" />
                                <x-input id="name" name="name" type="text" class="block w-full mt-1" value="{{ old('name') }}" />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <x-label for="email" value="Email" />
                                <x-input id="email" name="email" type="email" class="block w-full mt-1" value="{{ old('email') }}" />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div>
                                <x-label for="password" :value="__('Contraseña')" />
                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirmar Contraseña -->
                            <div>
                                <x-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
                                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                            </div>

                            <!-- Área -->
                            <div class="mb-4">
                                <x-label for="area_id" value="Área" />
                                <select id="area_id" name="area_id" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm">
                                    @foreach($areas as $area)
                                    <option value="{{ $area->id }}" {{ old('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
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
                                                {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}
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
                                {{ __('Crear Usuario') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
