<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Transportasi') }}
            </h2>
            <a href="{{ route('transportations.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition ease-in-out duration-150 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Transportasi
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($transportationList as $item)
                    <div class="group bg-white dark:bg-gray-800 rounded-2xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-300 border border-gray-100 dark:border-gray-700 flex flex-col">
                        <div class="relative h-56 overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-blue-600/90 backdrop-blur-sm text-white text-xs font-bold rounded-full shadow-lg">
                                    {{ $item->type->name }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 transition-colors">
                                    {{ $item->name }}
                                </h3>
                                <span class="text-xs font-mono px-2 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded">
                                    {{ $item->code }}
                                </span>
                            </div>
                            
                            <div class="flex items-center text-gray-500 dark:text-gray-400 text-sm mb-4">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                {{ $item->total_seat }} Kursi Tersedia
                            </div>

                            <hr class="border-gray-100 dark:border-gray-700 mb-4">

                            <div class="flex gap-3">
                                <a href="{{ route('transportations.edit', $item->id) }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800 rounded-xl hover:bg-amber-100 dark:hover:bg-amber-900/40 transition-all font-semibold text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('transportations.destroy', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus data transportasi {{ ucwords($item->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-all font-semibold text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>

                            <button type="submit" class="mt-4 w-full inline-flex justify-center items-center px-4 py-2 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 border border-green-200 dark:border-green-800 rounded-xl hover:bg-green-100 dark:hover:bg-green-900/40 transition-all font-semibold text-sm">
                                   
                                          <a href="{{ route('transportations.create', ['transportation_id' => $item->id]) }}" class="flex items-center justify-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
</svg>
                                        Pesan
                                        </a>
                              </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white dark:bg-gray-800 rounded-2xl p-12 text-center border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500 dark:text-gray-400">Belum ada data transportasi.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>