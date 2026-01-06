<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Eksplor Jadwal Perjalanan') }}
            </h2>
            <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-500/30">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                @forelse ($schedules as $schedule)
                    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl transition-all duration-500 border border-gray-100 dark:border-gray-700 group">
                        <div class="flex flex-col sm:flex-row">
                            
                            <div class="sm:w-2/5 relative h-48 sm:h-auto overflow-hidden">
                                @if($schedule->transportation->image)
                                    <img src="{{ asset('storage/' . $schedule->transportation->image) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                @else
                                    <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <span class="text-gray-400">No Image</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                                <div class="absolute bottom-4 left-4 text-white">
                                    <p class="text-xs font-medium opacity-80 uppercase tracking-wider">{{ $schedule->transportation->type->name }}</p>
                                    <h3 class="text-lg font-bold">{{ $schedule->transportation->name }}</h3>
                                    <div class="flex items-center mt-2 text-xs opacity-90">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z"/></svg>
                                        {{ $schedule->transportation->total_seat }} Kursi
                                    </div>
                                </div>
                            </div>

                            <div class="sm:w-3/5 p-6 flex flex-col justify-between bg-white dark:bg-gray-800">
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="text-xs font-mono px-2 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 rounded-lg font-bold">
                                            {{ $schedule->transportation->code }}
                                        </span>
                                        <span class="text-xl font-black text-emerald-600 dark:text-emerald-400">
                                            IDR {{ number_format($schedule->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="relative flex flex-col gap-4 mb-6">
                                        <div class="absolute left-2 top-2 bottom-2 w-0.5 border-l-2 border-dashed border-gray-200 dark:border-gray-600"></div>
                                        
                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-1 w-4 h-4 rounded-full border-4 border-white dark:border-gray-800 bg-indigo-500 shadow-[0_0_0_2px_rgba(99,102,241,0.3)]"></div>
                                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Keberangkatan</p>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $schedule->route->departure }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->departure)->translatedFormat('d M Y • H:i') }}</p>
                                        </div>

                                        <div class="relative pl-8">
                                            <div class="absolute left-0 top-1 w-4 h-4 rounded-full border-4 border-white dark:border-gray-800 bg-gray-300 dark:bg-gray-500"></div>
                                            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Tujuan</p>
                                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200">{{ $schedule->route->arrival }}</p>
                                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->arrival)->translatedFormat('d M Y • H:i') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <div class="flex gap-2">
                                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="flex-1 inline-flex justify-center items-center py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition-all text-xs font-bold">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Hapus jadwal {{ $schedule->transportation->name }} dari {{ $schedule->route->departure }} ke {{ $schedule->route->arrival }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full inline-flex justify-center items-center py-2.5 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-all text-xs font-bold border border-red-100 dark:border-red-900/50">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Spacing Pengkondisian Tombol Pesan --}}
                                    @if(true) {{-- Ganti dengan pengkondisian user (misal: if auth as passenger) --}}
                                        <a href="#" class="w-full inline-flex justify-center items-center py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-500/40 transition-all font-bold text-sm">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                            Pesan Tiket Sekarang
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-gray-500">Belum ada jadwal tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>