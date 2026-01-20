<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Booking') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-0 text-gray-900 dark:text-gray-100">
                    @if($bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-900/50">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Kode</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Pelanggan</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Rute & Kelas</th>
                                        <th
                                            class="px-6 py-4 text-left text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Total</th>
                                        <th
                                            class="px-6 py-4 text-center text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-right text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                                    @foreach($bookings as $booking)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap font-mono text-sm font-bold text-blue-600 dark:text-blue-400">
                                                #{{ $booking->booking_code }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-semibold">{{ $booking->user->name }}</div>
                                                <div class="text-xs text-gray-400">
                                                    {{ $booking->created_at->format('d M Y, H:i') }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium">{{ $booking->schedule->route->departure }} →
                                                    {{ $booking->schedule->route->arrival }}
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $booking->type->name }} Class</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold">
                                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                                @php
                                                    $statusClasses = [
                                                        'success' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                                                        'pending' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
                                                        'cancel' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                                    ];
                                                    $class = $statusClasses[$booking->status] ?? 'bg-gray-100 text-gray-700';
                                                @endphp
                                                <span class="px-3 py-1 text-xs font-bold rounded-full {{ $class }}">
                                                    {{ strtoupper($booking->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end gap-2">
                                                    {{-- Tombol Bayar (Hanya Icon agar rapi) --}}
                                                    @if($booking->status === 'pending' && auth()->id() == $booking->user_id)
                                                        <form action="{{ route('bookings.pay', $booking->id) }}" method="POST"
                                                            title="Bayar Sekarang">
                                                            @csrf @method('PATCH')
                                                            <button
                                                                class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition shadow-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                            </button>
                                                        </form>

                                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST"
                                                            onsubmit="return confirm('Batalkan pesanan #{{ $booking->booking_code }} Dari {{ $booking->schedule->route->departure }} Tujuan {{ $booking->schedule->route->arrival }}?')"
                                                            title="Batalkan">
                                                            @csrf @method('PATCH')
                                                            <button
                                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    {{-- Tombol Detail --}}
                                                    <a href="{{ route('bookings.show', $booking->id) }}"
                                                        class="p-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg transition"
                                                        title="Lihat Detail">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Empty State tetap sama --}}
                        <div class="text-center py-20">
                            <div
                                class="bg-gray-100 dark:bg-gray-700 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold">Belum ada booking</h3>
                            <p class="text-gray-500">Mulai petualangan Anda dengan memesan tiket sekarang.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>