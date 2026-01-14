<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Booking Tiket') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700">
                
                <div class="bg-blue-600 p-6 text-white flex justify-between items-center">
                    <div>
                        <p class="text-blue-100 text-xs uppercase tracking-widest font-bold">Kode Booking</p>
                        <h3 class="text-2xl font-mono font-bold">{{ $bookingDetail->booking_code }}</h3>
                    </div>
                    <div class="text-right">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-xs font-semibold backdrop-blur-sm uppercase tracking-wider">
                            Terkonfirmasi
                        </span>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center gap-6 mb-8 pb-8 border-b border-dashed border-gray-200 dark:border-gray-600">
                        <img class="w-24 h-24 object-cover rounded-2xl shadow-md ring-4 ring-gray-50 dark:ring-gray-700" 
                             src="{{ asset('storage/' . $bookingDetail->schedule->transportation->image) }}" 
                             alt="{{ $bookingDetail->schedule->transportation->name }}">
                        <div>
                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $bookingDetail->schedule->transportation->name }}</h4>
                            <p class="text-gray-500 dark:text-gray-400 font-medium">{{ $bookingDetail->schedule->transportation->code }} • {{ $bookingDetail->type->name }} Class</p>
                            <p class="text-sm text-blue-600 font-semibold mt-1 italic">Total Kapasitas: {{ $bookingDetail->schedule->transportation->total_seat }} Kursi</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center mb-10 text-center md:text-left">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Berangkat</p>
                            <h5 class="text-xl font-bold dark:text-white">{{ $bookingDetail->schedule->route->departure }}</h5>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($bookingDetail->schedule->date_departure)->format('d M Y, H:i') }}</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-full flex items-center justify-center">
                                <div class="h-[2px] flex-grow bg-gray-200 dark:bg-gray-700"></div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                                <div class="h-[2px] flex-grow bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                            <span class="text-[10px] text-gray-400 mt-2 font-bold uppercase">Perjalanan Langsung</span>
                        </div>
                        <div class="md:text-right">
                            <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Tiba Di</p>
                            <h5 class="text-xl font-bold dark:text-white">{{ $bookingDetail->schedule->route->arrival }}</h5>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($bookingDetail->schedule->date_arrival)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-900/50 rounded-2xl p-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Pemesan</p>
                            <p class="text-lg font-semibold dark:text-white">{{ $bookingDetail->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">ID Transaksi</p>
                            <p class="text-lg font-semibold dark:text-white">#{{ $bookingDetail->id }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Harga per Tiket</p>
                            <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($bookingDetail->type->price, 0, ',', '.') }}</p>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Pembayaran</p>
                            <p class="text-2xl font-black text-blue-600">Rp {{ number_format($bookingDetail->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-widest">Daftar Penumpang</h4>
                            <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">
                                {{ $passengers->count() }} Orang
                            </span>
                        </div>
                        <div class="overflow-hidden border border-gray-200 dark:border-gray-700 rounded-2xl">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Telepon</th>
                                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Kursi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse ($passengers as $passenger)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $passenger->passenger_name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $passenger->passenger_phone }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                                <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300 border border-blue-100 dark:border-blue-800">
                                                    {{ $passenger->seat_number }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-sm text-gray-500 italic">Tidak ada data penumpang tersedia.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <button onclick="window.print()" class="flex-1 bg-gray-900 dark:bg-white dark:text-gray-900 text-white font-bold py-3.5 px-6 rounded-xl hover:opacity-90 transition flex items-center justify-center gap-2 shadow-lg shadow-gray-200 dark:shadow-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Cetak Tiket
                        </button>
                        <a href="{{ route('bookings.list') }}" class="flex-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200 font-bold py-3.5 px-6 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 transition text-center flex items-center justify-center">
                            Kembali ke Daftar Booking
                        </a>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-900/80 px-8 py-4 border-t border-gray-100 dark:border-gray-700 text-center">
                    <p class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">Harap tunjukkan kartu identitas asli saat melakukan check-in di stasiun/terminal.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>