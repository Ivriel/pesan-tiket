<x-app-layout>
      <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Route
            </h2>
            <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer hover:bg-blue-800"
                onclick="window.history.back()">
                Back
            </button>
        </div>
    </x-slot>

     <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('routes.update',$route->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="departure" :value="__('Departure')" />
                            <x-text-input id="departure" name="departure" type="text" class="mt-1 block w-full" :value="old('departure',$route->departure)" required autofocus />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('departure')" />
                        </div>

                       
                        <div>
                            <x-input-label for="arrival" :value="__('Arrival')" />
                            <x-text-input id="arrival" name="arrival" type="text" class="mt-1 block w-full" :value="old('arrival',$route->arrival)" required autofocus />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('arrival')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Simpan Route') }}</x-primary-button>
                            
                            <a href="{{ route('routes.index') }}" class="text-sm text-gray-600 hover:underline">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                    </div>
            </div>
        </div>
    </div>


</x-app-layout>