<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Type
        </h2>
        <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer hover:bg-blue-800" onclick="window.history.back()">
            Back
        </button>
        </div>
    </x-slot>

     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('types.update', $type->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="name" :value="__('Nama Type')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $type->name)" required autofocus placeholder="Contoh: Eksekutif" />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
                        </div>

                         <div>
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Deskripsi tipe">{{ old('description', $type->description) }}</textarea>
                           @error('description')
                               <p class="mt-2 text-red-500">{{ $message }}</p>
                           @enderror
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Edit Type') }}</x-primary-button>
                            
                            <a href="{{ route('types.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>

</x-app-layout>