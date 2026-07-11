<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OfferStatus;
use App\Enums\ProjectStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\Project;
use App\Models\Provider;
use App\Services\Admin\ProjectService;

class DashboardController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {
    }

    public function index()
    {
        $stats = [
            'customers' => Customer::count(),
            'providers' => Provider::count(),
            'projects_total' => Project::count(),
            'projects_pending' => $this->projectService->getPendingProjectsQuery()->count(),
            'projects_active' => $this->projectService->getActiveProjectsQuery()->count(),
            'projects_completed' => $this->projectService->getCompletedProjectsQuery()->count(),
            'projects_cancelled' => Project::where('status', ProjectStatus::CANCELLED->value)->count(),
            'offers_total' => Offer::count(),
            'offers_pending' => Offer::where('status', OfferStatus::PENDING->value)->count(),
        ];

        $projectCounts = Project::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $projectChartLabels = [];
        $projectChartData = [];
        $projectChartColors = [];
        foreach (ProjectStatus::cases() as $case) {
            $count = (int) ($projectCounts[$case->value] ?? 0);
            if ($count === 0) {
                continue;
            }
            $projectChartLabels[] = ProjectStatus::getLabel($case->value);
            $projectChartData[] = $count;
            $projectChartColors[] = $this->colorForProjectStatus($case->value);
        }

        if ($projectChartData === []) {
            $projectChartLabels = [ProjectStatus::getLabel(ProjectStatus::PENDING->value)];
            $projectChartData = [0];
            $projectChartColors = ['#e5e7eb'];
        }

        $offerCounts = Offer::query()
            ->selectRaw('status, COUNT(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $offerChartLabels = [];
        $offerChartData = [];
        $offerChartColors = [];
        foreach (OfferStatus::cases() as $case) {
            $count = (int) ($offerCounts[$case->value] ?? 0);
            if ($count === 0) {
                continue;
            }
            $offerChartLabels[] = OfferStatus::getLabel($case->value);
            $offerChartData[] = $count;
            $offerChartColors[] = $this->colorForOfferStatus($case->value);
        }

        if ($offerChartData === []) {
            $offerChartLabels = [OfferStatus::getLabel(OfferStatus::PENDING->value)];
            $offerChartData = [0];
            $offerChartColors = ['#e5e7eb'];
        }

        $trendLabels = [];
        $trendData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $trendLabels[] = $month->format('Y/m');
            $trendData[] = Project::query()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return view('admin.dashboard', compact(
            'stats',
            'projectChartLabels',
            'projectChartData',
            'projectChartColors',
            'offerChartLabels',
            'offerChartData',
            'offerChartColors',
            'trendLabels',
            'trendData'
        ));
    }

    private function colorForProjectStatus(string $status): string
    {
        return match ($status) {
            ProjectStatus::REQUIRE_COMPLETE->value => '#94a3b8',
            ProjectStatus::PENDING->value => '#6366f1',
            ProjectStatus::ACCEPTED->value => '#3b82f6',
            ProjectStatus::FIRST_INSPECTION_SCHEDULED->value => '#8b5cf6',
            ProjectStatus::FIRST_INSPECTION_COMPLETED->value => '#a855f7',
            ProjectStatus::OPEN_FOR_OFFERS->value => '#f59e0b',
            ProjectStatus::IN_PROGRESS->value => '#10b981',
            ProjectStatus::COMPLETED->value => '#22c55e',
            ProjectStatus::CANCELLED->value => '#ef4444',
            default => '#9ca3af',
        };
    }

    private function colorForOfferStatus(string $status): string
    {
        return match ($status) {
            OfferStatus::PENDING->value => '#6366f1',
            OfferStatus::APPROVED->value => '#22c55e',
            OfferStatus::ACCEPTED->value => '#10b981',
            OfferStatus::COMPLETED->value => '#059669',
            OfferStatus::DECLINED->value => '#ef4444',
            OfferStatus::REQUIRE_UPDATE->value => '#f59e0b',
            OfferStatus::DRAFT->value => '#94a3b8',
            default => '#9ca3af',
        };
    }
}
