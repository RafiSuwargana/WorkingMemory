<div x-data="dashboardData()" class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header with gradient -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1
                        class="text-4xl font-extrabold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Admin Dashboard
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">Selamat datang di dashboard admin Working Memory Test</p>
                </div>
                <div class="text-sm text-gray-500">
                    {{ now()->format('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Statistics Cards with modern gradient -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
            <!-- Total Users Card -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl transform transition hover:scale-105 duration-200">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 opacity-20">
                    <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 20 20">
                        <path
                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                    </svg>
                </div>
                <div class="p-6 relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-medium uppercase tracking-wide">Total Peserta</p>
                            <p class="mt-2 text-4xl font-bold text-white">{{ $totalUsers }}</p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed Tests Card -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-xl transform transition hover:scale-105 duration-200">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 opacity-20">
                    <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-6 relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-medium uppercase tracking-wide">Selesai 3 Tes</p>
                            <p class="mt-2 text-4xl font-bold text-white">{{ $usersCompleted3Tests }}</p>
                            <p class="mt-1 text-sm text-green-100">
                                {{ $totalUsers > 0 ? round(($usersCompleted3Tests / $totalUsers) * 100) : 0 }}% dari
                                total
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Not Completed Tests Card -->
            <div
                class="relative overflow-hidden bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-xl transform transition hover:scale-105 duration-200">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 opacity-20">
                    <svg class="h-32 w-32" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="p-6 relative z-10">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-amber-100 text-sm font-medium uppercase tracking-wide">Belum Selesai 3 Tes
                            </p>
                            <p class="mt-2 text-4xl font-bold text-white">{{ $usersNotCompleted3Tests }}</p>
                            <p class="mt-1 text-sm text-amber-100">
                                {{ $totalUsers > 0 ? round(($usersNotCompleted3Tests / $totalUsers) * 100) : 0 }}% dari
                                total
                            </p>
                        </div>
                        <div class="bg-white bg-opacity-30 rounded-full p-3">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Donut Chart - Test Completion -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status Penyelesaian Tes</h3>
                <div id="completionChart"></div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white rounded-2xl shadow-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Cepat</h3>
                <div class="space-y-4">
                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-indigo-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Tingkat Penyelesaian</p>
                                <p class="text-2xl font-bold text-gray-900">
                                    {{ $totalUsers > 0 ? round(($usersCompleted3Tests / $totalUsers) * 100) : 0 }}%
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-emerald-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Peserta Aktif</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="flex items-center justify-between p-4 bg-gradient-to-r from-rose-50 to-rose-100 rounded-xl">
                        <div class="flex items-center">
                            <div class="bg-rose-500 rounded-lg p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-600">Perlu Tindak Lanjut</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $usersNotCompleted3Tests }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Cepat</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <a href="{{ route('admin.users') }}"
                    class="group relative overflow-hidden flex items-center p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl hover:from-blue-100 hover:to-indigo-100 transition-all duration-200 border-2 border-transparent hover:border-blue-300">
                    <div class="flex items-center space-x-4">
                        <div
                            class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-3 shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-gray-900">Kelola Pengguna</p>
                            <p class="text-sm text-gray-600">Lihat dan kelola data pengguna</p>
                        </div>
                    </div>
                    <svg class="absolute right-4 h-6 w-6 text-gray-400 group-hover:text-blue-600 group-hover:translate-x-1 transition-all duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('admin.laporan') }}"
                    class="group relative overflow-hidden flex items-center p-6 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl hover:from-green-100 hover:to-emerald-100 transition-all duration-200 border-2 border-transparent hover:border-green-300">
                    <div class="flex items-center space-x-4">
                        <div
                            class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-3 shadow-lg group-hover:scale-110 transition-transform duration-200">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-base font-semibold text-gray-900">Laporan Tes</p>
                            <p class="text-sm text-gray-600">Lihat hasil tes semua peserta</p>
                        </div>
                    </div>
                    <svg class="absolute right-4 h-6 w-6 text-gray-400 group-hover:text-green-600 group-hover:translate-x-1 transition-all duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        function dashboardData() {
            return {
                init() {
                    this.renderCompletionChart();
                },
                renderCompletionChart() {
                    const options = {
                        series: [{{ $usersCompleted3Tests }}, {{ $usersNotCompleted3Tests }}],
                        chart: {
                            type: 'donut',
                            height: 350,
                            animations: {
                                enabled: true,
                                easing: 'easeinout',
                                speed: 800,
                            }
                        },
                        labels: ['Selesai 3 Tes', 'Belum Selesai'],
                        colors: ['#10b981', '#f59e0b'],
                        legend: {
                            position: 'bottom',
                            fontSize: '14px',
                            fontFamily: 'inherit',
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function (val) {
                                return Math.round(val) + "%"
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        total: {
                                            show: true,
                                            label: 'Total Peserta',
                                            fontSize: '16px',
                                            fontWeight: 600,
                                            color: '#374151',
                                            formatter: function () {
                                                return {{ $totalUsers }}
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                chart: {
                                    height: 300
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    const chart = new ApexCharts(document.querySelector("#completionChart"), options);
                    chart.render();
                }
            }
        }
    </script>
</div>