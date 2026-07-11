@extends('admin.layouts.main')
@section('title', 'لوحة التحكم - المشرف')

@push('styles')
    <style>
        .admin-dashboard {
            padding: 1.25rem 1.5rem 2rem;
        }
        .admin-dashboard .page-head {
            margin-bottom: 1.5rem;
        }
        .admin-dashboard .page-head h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .admin-dashboard .page-head p {
            color: #6b7280;
            margin: 0;
            font-size: 0.95rem;
        }
        .admin-dashboard .stat-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .admin-dashboard .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.1rem 1.25rem;
            text-decoration: none;
            color: inherit;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            transition: box-shadow 0.15s ease, border-color 0.15s ease;
        }
        .admin-dashboard a.stat-card:hover {
            border-color: #f5932e;
            box-shadow: 0 4px 14px rgba(17, 17, 17, 0.06);
        }
        .admin-dashboard .stat-card .label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 0.35rem;
        }
        .admin-dashboard .stat-card .value {
            font-size: 1.65rem;
            font-weight: 700;
            color: #111827;
        }
        .admin-dashboard .stat-card .icon {
            color: #f5932e;
            font-size: 1.35rem;
            opacity: 0.9;
            margin-top: 0.15rem;
            flex-shrink: 0;
        }
        .admin-dashboard .stat-card .stat-body {
            min-width: 0;
        }
        .admin-dashboard .charts-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }
        .admin-dashboard .chart-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 1.25rem;
        }
        .admin-dashboard .chart-card h2 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #111827;
        }
        .admin-dashboard .chart-card .chart-wrap {
            position: relative;
            height: 260px;
        }
        .admin-dashboard .chart-card.wide .chart-wrap {
            height: 280px;
        }
        .admin-dashboard  {
padding-right: 300px !important;

        }
    </style>
@endpush

@section('content')
    <div class="admin-dashboard" id="main_page">
        <div class="page-head">
            <h1>لوحة التحكم</h1>
            <p>نظرة سريعة على أرقام المنصة والمشاريع والعروض</p>
        </div>

        <div class="stat-cards">
            @can('view customers')
                <a href="{{ route('admin.customers.index') }}" class="stat-card">
                    <i class="fa-solid fa-users icon"></i>
                    <div class="stat-body">
                        <div class="label">العملاء</div>
                        <div class="value">{{ number_format($stats['customers']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-solid fa-users icon"></i>
                    <div class="stat-body">
                        <div class="label">العملاء</div>
                        <div class="value">{{ number_format($stats['customers']) }}</div>
                    </div>
                </div>
            @endcan

            @can('view providers')
                <a href="{{ route('admin.providers.index') }}" class="stat-card">
                    <i class="fa-solid fa-user-gear icon"></i>
                    <div class="stat-body">
                        <div class="label">مزودو الخدمة</div>
                        <div class="value">{{ number_format($stats['providers']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-solid fa-user-gear icon"></i>
                    <div class="stat-body">
                        <div class="label">مزودو الخدمة</div>
                        <div class="value">{{ number_format($stats['providers']) }}</div>
                    </div>
                </div>
            @endcan

            <div class="stat-card">
                <i class="fa-solid fa-diagram-project icon"></i>
                <div class="stat-body">
                    <div class="label">إجمالي المشاريع</div>
                    <div class="value">{{ number_format($stats['projects_total']) }}</div>
                </div>
            </div>

            @can('view projects.pending')
                <a href="{{ route('admin.projects.pending.index') }}" class="stat-card">
                    <i class="fa-regular fa-hourglass-half icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع معلقة</div>
                        <div class="value">{{ number_format($stats['projects_pending']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-regular fa-hourglass-half icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع معلقة</div>
                        <div class="value">{{ number_format($stats['projects_pending']) }}</div>
                    </div>
                </div>
            @endcan

            @can('view projects.active')
                <a href="{{ route('admin.projects.active.index') }}" class="stat-card">
                    <i class="fa-solid fa-bolt icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع نشطة</div>
                        <div class="value">{{ number_format($stats['projects_active']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-solid fa-bolt icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع نشطة</div>
                        <div class="value">{{ number_format($stats['projects_active']) }}</div>
                    </div>
                </div>
            @endcan

            @can('view projects.completed')
                <a href="{{ route('admin.projects.completed.index') }}" class="stat-card">
                    <i class="fa-regular fa-circle-check icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع مكتملة</div>
                        <div class="value">{{ number_format($stats['projects_completed']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-regular fa-circle-check icon"></i>
                    <div class="stat-body">
                        <div class="label">مشاريع مكتملة</div>
                        <div class="value">{{ number_format($stats['projects_completed']) }}</div>
                    </div>
                </div>
            @endcan

            <div class="stat-card">
                <i class="fa-solid fa-ban icon"></i>
                <div class="stat-body">
                    <div class="label">مشاريع ملغاة</div>
                    <div class="value">{{ number_format($stats['projects_cancelled']) }}</div>
                </div>
            </div>

            @can('view offers.pending')
                <a href="{{ route('admin.offers.pending.index') }}" class="stat-card">
                    <i class="fa-solid fa-briefcase icon"></i>
                    <div class="stat-body">
                        <div class="label">عروض قيد المراجعة</div>
                        <div class="value">{{ number_format($stats['offers_pending']) }}</div>
                    </div>
                </a>
            @else
                <div class="stat-card">
                    <i class="fa-solid fa-briefcase icon"></i>
                    <div class="stat-body">
                        <div class="label">عروض قيد المراجعة</div>
                        <div class="value">{{ number_format($stats['offers_pending']) }}</div>
                    </div>
                </div>
            @endcan

            <div class="stat-card">
                <i class="fa-solid fa-layer-group icon"></i>
                <div class="stat-body">
                    <div class="label">إجمالي العروض</div>
                    <div class="value">{{ number_format($stats['offers_total']) }}</div>
                </div>
            </div>
        </div>

        <div class="charts-row">
            <div class="chart-card">
                <h2>توزيع المشاريع حسب الحالة</h2>
                <div class="chart-wrap">
                    <canvas id="chartProjectsByStatus"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <h2>توزيع العروض حسب الحالة</h2>
                <div class="chart-wrap">
                    <canvas id="chartOffersByStatus"></canvas>
                </div>
            </div>
        </div>

        <div class="chart-card wide">
            <h2>المشاريع الجديدة (آخر 6 أشهر)</h2>
            <div class="chart-wrap">
                <canvas id="chartProjectsTrend"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" crossorigin="anonymous"></script>
    <script>
        (function () {
            const rtl = document.documentElement.getAttribute('dir') === 'rtl';
            const fontFamily = getComputedStyle(document.body).fontFamily || 'Tahoma, sans-serif';

            const projectLabels = @json($projectChartLabels);
            const projectData = @json($projectChartData);
            const projectColors = @json($projectChartColors);

            const offerLabels = @json($offerChartLabels);
            const offerData = @json($offerChartData);
            const offerColors = @json($offerChartColors);

            const trendLabels = @json($trendLabels);
            const trendData = @json($trendData);

            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        rtl: rtl,
                        labels: { font: { family: fontFamily }, boxWidth: 12 }
                    }
                }
            };

            new Chart(document.getElementById('chartProjectsByStatus'), {
                type: 'doughnut',
                data: {
                    labels: projectLabels,
                    datasets: [{
                        data: projectData,
                        backgroundColor: projectColors,
                        borderWidth: 1,
                        borderColor: '#fff'
                    }]
                },
                options: commonOptions
            });

            new Chart(document.getElementById('chartOffersByStatus'), {
                type: 'doughnut',
                data: {
                    labels: offerLabels,
                    datasets: [{
                        data: offerData,
                        backgroundColor: offerColors,
                        borderWidth: 1,
                        borderColor: '#fff'
                    }]
                },
                options: commonOptions
            });

            new Chart(document.getElementById('chartProjectsTrend'), {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'عدد المشاريع',
                        data: trendData,
                        fill: true,
                        tension: 0.25,
                        borderColor: '#f5932e',
                        backgroundColor: 'rgba(245, 147, 46, 0.12)',
                        pointBackgroundColor: '#f5932e',
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            ticks: { font: { family: fontFamily } },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1, font: { family: fontFamily } }
                        }
                    }
                }
            });
        })();
    </script>
@endpush
