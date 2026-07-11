<?php

namespace App\Http\Controllers\Provider;

use App\Enums\OfferStatus;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $providerId = auth('provider')->id();

        // ✅ حساب المشاريع حسب الحالة
        $completed = Offer::where('provider_id', $providerId)
            ->where('status', OfferStatus::COMPLETED->value)
            ->count();

        $pending = Offer::where('provider_id', $providerId)
            ->where('status', OfferStatus::PENDING->value)
            ->count();

        $delayed = Offer::where('provider_id', $providerId)
            ->where('status', OfferStatus::DECLINED->value)
            ->count();

        $total = $delayed + $pending + $completed;

        $stats = [
            [
                'title' => 'المشاريع المتأخرة',
                'count' => $delayed,
                'percent' => $total > 0 ? round(($delayed / $total) * 100, 1) . '%' : '0%',
            ],
            [
                'title' => 'المشاريع المعلقة',
                'count' => $pending,
                'percent' => $total > 0 ? round(($pending / $total) * 100, 1) . '%' : '0%',
            ],
            [
                'title' => 'المشاريع المكتملة',
                'count' => $completed,
                'percent' => $total > 0 ? round(($completed / $total) * 100, 1) . '%' : '0%',
            ],
            [
                'title' => 'إجمالي المشاريع',
                'count' => $total,
                'percent' => '100%',
            ],
        ];

        // ✅ جلب المشاريع مع البحث والفلاتر والفترة
        $projects = Project::whereHas('offers', function ($query) use ($providerId) {
            $query->where('provider_id', $providerId)
                ->whereIn('status', [
                    \App\Enums\ProjectStatus::IN_PROGRESS->value,
                    \App\Enums\ProjectStatus::ACCEPTED->value,
                    // \App\Enums\ProjectStatus::COMPLETED->value,
                    // \App\Enums\ProjectStatus::CANCELLED->value,
              
                    // \App\Enums\ProjectStatus::OPEN_FOR_OFFERS->value
             
                ]);
        })
            ->with(['serviceType', 'buildingType'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($query) use ($request) {
                    $query->where('work_description', 'like', '%' . $request->search . '%')
                        ->orWhereHas('serviceType', function ($q2) use ($request) {
                            $q2->where('name', 'like', '%' . $request->search . '%');
                        })
                        ->orWhereHas('buildingType', function ($q3) use ($request) {
                            $q3->where('name', 'like', '%' . $request->search . '%');
                        });
                });
            })
            ->when($request->filled('filter'), function ($q) use ($request) {
                $q->where('status', $request->filter);
            })
            ->when($request->filled('period'), function ($q) use ($request) {
                if ($request->period === 'month') {
                    $q->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year);
                } elseif ($request->period === 'week') {
                    $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                } elseif ($request->period === 'day') {
                    $q->whereDate('created_at', now()->toDateString());
                }
            })
            ->get();


        $period = $request->get('period', 'month');


        $months = ['1' => 'يناير', '2' => 'فبراير', '3' => 'مارس', '4' => 'أبريل', '5' => 'مايو', '6' => 'يونيو', '7' => 'يوليو', '8' => 'أغسطس', '9' => 'سبتمبر', '10' => 'أكتوبر', '11' => 'نوفمبر', '12' => 'ديسمبر'];
        $days = ['Saturday' => 'السبت', 'Sunday' => 'الأحد', 'Monday' => 'الاثنين', 'Tuesday' => 'الثلاثاء', 'Wednesday' => 'الأربعاء', 'Thursday' => 'الخميس', 'Friday' => 'الجمعة'];

        // بيانات شهرية
        $chartDataMonthly = Project::where('provider_id', $providerId)
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->mapWithKeys(fn($value, $key) => [$months[$key] => $value]);
       


        // بيانات أسبوعية
        $chartDataWeekly = Project::where('provider_id', $providerId)
            ->selectRaw('WEEK(created_at) as week, COUNT(*) as total')
            ->groupBy('week')
            ->pluck('total', 'week')
            ->mapWithKeys(fn($value, $key) => ["الأسبوع $key" => $value]);

        // بيانات يومية
        $chartDataDaily = Project::where('provider_id', $providerId)
            ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
            ->groupBy('day')
            ->pluck('total', 'day')
            ->mapWithKeys(fn($value, $key) => [$days[$key] => $value]);


        return view('provider.dashboard', [
            'projects' => $projects,
            'stats' => $stats,
            'period' => $period,
            'chartDataMonthly' => $chartDataMonthly,
            'chartDataWeekly' => $chartDataWeekly,
            'chartDataDaily' => $chartDataDaily,
        ]);
    }

}
