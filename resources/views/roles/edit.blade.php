<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('roles.update', $role) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-label for="name" value="{{ __('Nombre del Rol') }}" />
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $role->name)" required autofocus />
                            <x-input-error for="name" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-label value="{{ __('Permisos') }}" />
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                                @php
                                    $oldPermissions = old('permissions', $role->permissions->pluck('id')->toArray());
                                @endphp

                                @foreach($permissions as $permission)
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="permission_{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}"
                                            {{ in_array($permission->id, $oldPermissions) ? 'checked' : '' }}
                                            class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="permission_{{ $permission->id }}" class="font-medium text-gray-700">{{ $permission->name }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition mr-2">
                                Cancelar
                            </a>
                            <x-button class="ml-4">
                                {{ __('Actualizar Rol') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
