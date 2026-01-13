<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pesan Tiket Perjalanan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                <div class="relative h-64 w-full">
                    <img src="{{ asset('storage/' . $schedule->transportation->image) }}" 
                         alt="{{ $schedule->transportation->name }}" 
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute bottom-6 left-8 text-white">
                        <span class="px-3 py-1 bg-blue-600 text-xs font-bold uppercase rounded-full tracking-wider">
                            {{ $schedule->transportation->code }}
                        </span>
                        <h1 class="text-3xl font-bold mt-2">{{ $schedule->transportation->name }}</h1>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex flex-col md:flex-row justify-between items-center mb-10 pb-8 border-b border-gray-100 dark:border-gray-700">
                        <div class="text-center md:text-left">
                            <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-widest font-semibold">Keberangkatan</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $schedule->route->departure }}</h3>
                            <p class="text-sm text-blue-600 font-medium">{{ \Carbon\Carbon::parse($schedule->date_departure)->format('d M Y, H:i') }}</p>
                        </div>

                        <div class="flex flex-col items-center py-4 md:py-0">
                            <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>

                        <div class="text-center md:text-right">
                            <p class="text-sm text-gray-500 dark:text-gray-400 uppercase tracking-widest font-semibold">Tujuan</p>
                            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $schedule->route->arrival }}</h3>
                            <p class="text-sm text-blue-600 font-medium">{{ \Carbon\Carbon::parse($schedule->date_arrival)->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    <form action="{{ route('bookings.store') }}" method="POST"> @csrf
                        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                        <!-- Pilih Kelas -->
                        <div class="mb-8">
                            <label for="type_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                Pilih Kelas & Tipe Tiket
                            </label>
                            <select name="type_id" id="type_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-blue-500 focus:border-blue-500 shadow-sm transition" required>
                                <option value="">-- Pilih Kelas --</option>
                                @forelse ($availableTypes as $type)
                                    <option value="{{ $type->id }}" data-price="{{ $type->price }}">
                                        {{ $type->name }} — Rp {{ number_format($type->price, 0, ',', '.') }}
                                    </option>
                                @empty
                                    <option value="">Tidak ada tipe tersedia</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- Data Penumpang -->
                        <div class="mb-8">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Data Penumpang
                                </label>
                                <button type="button" id="addPassenger" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    + Tambah Penumpang
                                </button>
                            </div>
                            
                            <div id="passengerContainer">
                                <div class="passenger-form bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap</label>
                                            <input type="text" name="passengers[0][name]" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">No. Telepon</label>
                                            <input type="text" name="passengers[0][phone]" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Kursi</label>
                                            <select name="passengers[0][seat_number]" class="seat-select w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required>
                                                <option value="">Pilih kursi</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="button" class="remove-passenger text-red-600 hover:text-red-700 text-xs mt-2 hidden">Hapus Penumpang</button>
                                </div>
                            </div>
                        </div>

                        <!-- Total Harga -->
                        <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Total Harga:</span>
                                <span id="totalPrice" class="text-xl font-bold text-blue-600">Rp 0</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Harga sudah termasuk pajak dan biaya layanan</p>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200 transform hover:scale-[1.02] active:scale-95 shadow-lg shadow-blue-500/30">
                            Konfirmasi Pemesanan
                        </button>
                    </form>

                    <p class="mt-6 text-xs text-center text-gray-400">
                        ID Jadwal: #{{ $schedule->id }} • Pastikan data keberangkatan sudah sesuai sebelum melakukan pemesanan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const BookingApp = {
            passengerCount: 1,
            availableSeats: [],
            selectedPrice: 0,
            scheduleId: {{ $schedule->id }},

            init() {
                this.bindEvents();
            },

            bindEvents() {
                document.getElementById('type_id').addEventListener('change', (e) => this.handleTypeChange(e));
                document.getElementById('addPassenger').addEventListener('click', () => this.addPassenger());
                document.addEventListener('change', (e) => e.target.classList.contains('seat-select') && this.updateSeatAvailability());
                document.querySelector('form').addEventListener('submit', (e) => this.validateForm(e));
            },

            handleTypeChange(e) {
                const typeId = e.target.value;
                this.selectedPrice = parseFloat(e.target.options[e.target.selectedIndex].dataset.price) || 0;
                typeId ? this.loadSeats(typeId) : this.clearSeats();
                this.updatePrice();
            },

            addPassenger() {
                const container = document.getElementById('passengerContainer');
                const form = this.createPassengerForm();
                container.appendChild(form);
                this.passengerCount++;
                this.populateSeatOptions(form.querySelector('.seat-select'));
                this.toggleRemoveButtons();
                this.updatePrice();
            },

            createPassengerForm() {
                const form = document.createElement('div');
                form.className = 'passenger-form bg-gray-50 dark:bg-gray-700 p-4 rounded-lg mb-4';
                form.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap</label>
                        <input type="text" name="passengers[${this.passengerCount}][name]" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required></div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">No. Telepon</label>
                        <input type="text" name="passengers[${this.passengerCount}][phone]" class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required></div>
                        <div><label class="block text-xs font-medium text-gray-600 dark:text-gray-400 mb-1">Kursi</label>
                        <select name="passengers[${this.passengerCount}][seat_number]" class="seat-select w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-800 text-sm" required>
                            <option value="">Pilih kursi</option></select></div>
                    </div>
                    <button type="button" class="remove-passenger text-red-600 hover:text-red-700 text-xs mt-2">Hapus Penumpang</button>`;
                form.querySelector('.remove-passenger').addEventListener('click', () => {
                    form.remove();
                    this.updatePrice();
                });
                return form;
            },

            toggleRemoveButtons() {
                const removeBtn = document.querySelector('.remove-passenger');
                if (removeBtn) removeBtn.classList.toggle('hidden', this.passengerCount <= 1);
            },

            async loadSeats(typeId) {
                try {
                    const response = await fetch(`{{ route('api.seats') }}?schedule_id=${this.scheduleId}&type_id=${typeId}`);
                    const data = await response.json();
                    this.availableSeats = data.seats;
                    this.populateAllSeats();
                } catch (error) {
                    console.error('Error loading seats:', error);
                    alert('Gagal memuat data kursi. Silakan refresh halaman.');
                }
            },

            populateAllSeats() {
                document.querySelectorAll('.seat-select').forEach(select => this.populateSeatOptions(select));
            },

            populateSeatOptions(select) {
                const currentValue = select.value;
                select.innerHTML = '<option value="">Pilih kursi</option>';
                this.availableSeats.forEach(seat => {
                    const option = new Option(`Kursi ${seat.number}${!seat.available ? ' (Sudah dipesan)' : ''}`, seat.number);
                    option.disabled = !seat.available;
                    select.appendChild(option);
                });
                if (currentValue && this.availableSeats.find(s => s.number == currentValue && s.available)) {
                    select.value = currentValue;
                }
            },

            clearSeats() {
                document.querySelectorAll('.seat-select').forEach(select => {
                    select.innerHTML = '<option value="">Pilih kelas terlebih dahulu</option>';
                });
            },

            updatePrice() {
                const total = this.selectedPrice * document.querySelectorAll('.passenger-form').length;
                document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
            },

            updateSeatAvailability() {
                const selectedSeats = [...document.querySelectorAll('.seat-select')].map(s => s.value).filter(Boolean);
                document.querySelectorAll('.seat-select').forEach(select => {
                    [...select.options].forEach(option => {
                        if (option.value && option.value !== select.value) {
                            const seatData = this.availableSeats.find(s => s.number == option.value);
                            const isSelectedByOther = selectedSeats.includes(option.value) && option.value !== select.value;
                            option.disabled = !seatData?.available || isSelectedByOther;
                            option.textContent = `Kursi ${option.value}${!seatData?.available ? ' (Sudah dipesan)' : isSelectedByOther ? ' (Dipilih penumpang lain)' : ''}`;
                        }
                    });
                });
            },

            validateForm(e) {
                const selectedSeats = [...document.querySelectorAll('.seat-select')].map(s => s.value).filter(Boolean);
                const uniqueSeats = [...new Set(selectedSeats)];
                
                if (selectedSeats.length !== uniqueSeats.length) {
                    e.preventDefault();
                    alert('Tidak boleh memilih kursi yang sama untuk penumpang berbeda!');
                } else if (!selectedSeats.length) {
                    e.preventDefault();
                    alert('Silakan pilih kursi untuk semua penumpang!');
                }
            }
        };

        document.addEventListener('DOMContentLoaded', () => BookingApp.init());
    </script>
</x-app-layout>