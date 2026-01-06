<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Schedule
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

                    <form method="POST" action="{{ route('schedules.update', $schedule->id) }}"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')


                        <div>

                            <x-input-label for="date_departure" :value="__('Date Departure (Tanggal & Waktu)')" />
                            <input type="datetime-local" id="date_departure" name="date_departure"
                                value="{{ old('departure', $schedule->date_departure) }}" autofocus
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @error('date_departure')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>

                            <x-input-label for="date_arrival" :value="__('Date Arrival (Tanggal & Waktu)')" />
                            <input type="datetime-local" id="date_arrival" name="date_arrival"
                                value="{{ old('date_arrival', $schedule->date_arrival) }}"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            @error('date_arrival')
                                <p class="mt-2 text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <x-input-label for="price" :value="__('price')" />
                            <x-text-input id="price" name="price" min=0 type="number" class="mt-1 block w-full"
                                :value="old('price', $schedule->price)" required />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('price')" />
                        </div>

                        <div>
                            <x-input-label for="transportation_id" :value="__('Tipe Transportasi')" />
                            <select name="transportation_id" id="transportation_id"
                                class="text-white mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500"
                                required>
                                @foreach ($transportations as $transportation)
                                    <option value="{{ $transportation->id }}"
                                        data-image="{{ $transportation->image ? asset('storage/' . $transportation->image) : '' }}"
                                        {{ old('transportation_id', $schedule->transportation_id) == $transportation->id ? 'selected' : '' }}>
                                        {{ $transportation->name }} - {{ $transportation->type->name }} -
                                        {{ $transportation->code }}
                                    </option>
                                @endforeach
                            </select>

                            <div id="transportPreviewWrapper" class="mt-4 hidden">
                                <p class="text-sm text-gray-400 mb-2">Preview Armada Transportasi:</p>
                                <img id="transPreview" src=""
                                    class="w-full max-w-md rounded-xl shadow-lg border-2 border-gray-600 object-cover hidden"
                                    style="height: 500px;" alt="Preview armada">
                                <p id="transPreviewPlaceholder" class="text-sm text-gray-500">Tidak ada gambar untuk
                                    armada ini.</p>
                            </div>
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('transportation_id')" />
                        </div>

                        <div>
                            <x-input-label for="route_id" :value="__('Rute')" />
                            <select name="route_id" id="route_id"
                                class="text-white mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500"
                                required>
                                @foreach ($routes as $route)
                                    <option value="{{ $route->id }}"
                                        {{ old('route_id',$route->id) == $route->id ? 'selected' : '' }}>
                                        from {{ $route->departure }} to {{ $route->arrival }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('transportation_id')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Edit Jadwal') }}</x-primary-button>

                            <a href="{{ route('transportations.index') }}"
                                class="text-sm text-gray-600 hover:underline">
                                {{ __('Batal') }}
                            </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const select = document.getElementById('transportation_id');
            const previewWrapper = document.getElementById('transportPreviewWrapper');
            const previewImg = document.getElementById('transPreview');
            const placeholder = document.getElementById('transPreviewPlaceholder');

            const updatePreview = () => {
                const selected = select.selectedOptions[0];
                const imgSrc = selected?.dataset.image;

                if (imgSrc) {
                    previewImg.src = imgSrc;
                    previewImg.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }

                previewWrapper.classList.remove('hidden');
            };

            select.addEventListener('change', updatePreview);
            updatePreview(); // set initial preview
        });
    </script>
</x-app-layout>
