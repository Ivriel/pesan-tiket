<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Edit Transportation
            </h2>
            <button class="bg-blue-500 text-white py-2 px-4 rounded cursor-pointer hover:bg-blue-800"
                onclick="window.history.back()">
                Back
            </button>
        </div>
    </x-slot>

    <script>
      function previewImage(){
    const file = document.getElementById('image').files[0];
    const preview = document.getElementById('imagePreview');
    const container = document.getElementById('newImageContainer'); // Ambil ID container

    if(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block'; // Munculkan container (termasuk teks)
        }
        reader.readAsDataURL(file);
    } else {
        container.style.display = 'none'; // Sembunyikan jika batal pilih file
    }
}
    </script>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form method="POST" action="{{ route('transportations.update',$transportation->id) }}" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf
                        @method('PUT')

                        @if ($transportation->image)
                            <div class="mb-2">
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Gambar saat ini:</p>
                                <img src="{{ asset('storage/' . $transportation->image) }}"
                                    alt="Current transportation image" class="w-32 h-24 object-cover rounded border">
                            </div>
                        @endif
                      <div id="newImageContainer" style="display: none;" class="mt-4">
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Image baru:</p>
    <img id="imagePreview" style="max-width: 200px;" class="rounded border">
</div>
                        <div class="col-span-2">
                            <x-input-label for="image" :value="__('image Transportasi')" />
                            <input value="{{ old('image') }}" type="file" name="image" id="image"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 py-2 px-2">
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('image')" />
                        </div>
                        <script>
                            document.getElementById('image').addEventListener('change', previewImage)
                        </script>

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $transportation->name)" required autofocus />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('name')" />
                        </div>


                        <div>
                            <x-input-label for="code" :value="__('Code')" />
                            <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                                :value="old('code', $transportation->code)" required autofocus />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('code')" />
                        </div>

                        <div>
                            <x-input-label for="total_seat" :value="__('total_seat')" />
                            <x-text-input id="total_seat" name="total_seat" type="number" class="mt-1 block w-full"
                                :value="old('total_seat', $transportation->total_seat)" required autofocus />
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('total_seat')" />
                        </div>

                        <div>
                            <x-input-label for="type_id" :value="__('Tipe Transportasi')" />
                            <select name="type_id" id="type_id"
                                class="text-white mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500"
                                required>
                                @foreach($listType as $type)
                                    <option value="{{ $type->id }}" {{ old('type_id', $transportation->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2 text-red-500" :messages="$errors->get('type_id')" />
                        </div>

                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Edit Transportasi') }}</x-primary-button>

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



</x-app-layout>