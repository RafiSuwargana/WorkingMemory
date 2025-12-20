<div x-data="dashboardData()" class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">
                        Admin Dashboard
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">Selamat datang di dashboard admin Working Memory Test</p>
                </div>
                <div class="text-sm text-gray-400">
                    {{ now()->format('d F Y') }}
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3 mb-8">
            <!-- Total Users Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Peserta</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Completed Tests Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Selesai 3 Tes</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $usersCompleted3Tests }}</p>
                        <p class="mt-1 text-sm text-gray-400">
                            {{ $totalUsers > 0 ? round(($usersCompleted3Tests / $totalUsers) * 100) : 0 }}% dari total
                        </p>
                    </div>
                    <div class="p-3 bg-green-50 rounded-lg">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Not Completed Tests Card -->
            <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Belum Selesai 3 Tes</p>
                        <p class="mt-2 text-3xl font-semibold text-gray-900">{{ $usersNotCompleted3Tests }}</p>
                        <p class="mt-1 text-sm text-gray-400">
                            {{ $totalUsers > 0 ? round(($usersNotCompleted3Tests / $totalUsers) * 100) : 0 }}% dari
                            total
                        </p>
                    </div>
                    <div class="p-3 bg-amber-50 rounded-lg">
                        <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-8">
            <!-- Donut Chart - Test Completion -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Status Penyelesaian Tes</h3>
                <div id="completionChart"></div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Statistik Cepat</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-gray-800 rounded-lg p-3">
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

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-green-600 rounded-lg p-3">
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

                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="bg-amber-600 rounded-lg p-3">
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
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <h2 class="text-base font-semibold text-gray-900 mb-4">Menu Cepat</h2>
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                <a href="{{ route('admin.users') }}"
                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Kelola Pengguna</p>
                            <p class="text-xs text-gray-500">Lihat dan kelola data pengguna</p>
                        </div>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('admin.laporan') }}"
                    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:border-gray-300 hover:shadow-sm transition-all duration-200">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-gray-100 rounded-lg">
                            <svg class="h-5 w-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Laporan Tes</p>
                            <p class="text-xs text-gray-500">Lihat hasil tes semua peserta</p>
                        </div>
                    </div>
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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