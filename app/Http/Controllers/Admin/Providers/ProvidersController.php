<?php

namespace App\Http\Controllers\Admin\Providers;

use App\Enums\ProviderStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Provider;
use App\Services\Admin\ProviderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDO;
use Yajra\DataTables\Facades\DataTables;

class ProvidersController extends Controller
{
    protected $providerService;

    public function __construct(ProviderService $providerService)
    {
        $this->providerService = $providerService;
    }

    public function index(Request $request)
    {
           if (!Auth::user('admin')->can('view providers'))
            abort(403);
        if ($request->ajax()) {
            $providers = $this->providerService->getActiveProvidersQuery();
            // ⚠️ IMPORTANT: make sure this returns a query builder, not a collection

            return DataTables::of($providers)
                ->addColumn('status', function ($row) {
                    return \App\Enums\ProviderStatus::getLabel($row->status);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('view providers')) {
                        $btn .= '<a href="' . route('admin.providers.show', $row->id) . '">
                                <i class="fa-regular fa-eye"></i>
                             </a>';
                    }
                    return $btn;
                })
                  ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.providers.index');
    }


    
    public function requests(Request $request)
    {
           if (!Auth::user('admin')->can('view providers.requests'))
            abort(403);

        if ($request->ajax()) {
            $providers = $this->providerService->getRequestsQuery();

            return DataTables::of($providers)
                ->addColumn('status', function ($row) {
                    return \App\Enums\ProviderStatus::getLabel($row->status);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('view providers')) {
                        $btn .= '<a href="' . route('admin.providers.requests.edit' , $row->id) . '">
                                <i class="fa-regular fa-eye"></i>
                             </a>';
                    }
                    return $btn;
                })
                  ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.providers.requests.index');
    }

  

    public function show($id)
    {
        $provider = Provider::find($id);
        $attachments = [];
        foreach (config('provider.files') as $type) {
            $attachments[$type['label']] = $provider->attachments()->where('file_name', $type['name'])->get();
        }
        return view('admin.providers.show', compact('provider', 'attachments'));
    }

    public function edit($id)
    {
        $request = Provider::find($id);
        $attachments = [];
        foreach (config('provider.files') as $type) {
            $attachments[$type['label']] = $request->attachments()->where('file_name', $type['name'])->get();
        }
        return view('admin.providers.requests.edit', compact('request', 'attachments'));
    }

    public function updateStatus($id, Request $request)
    {
        $request->validate(['status' => 'required|in:active,pending,require_update']);
        $comment = $request->msg ?? '';

        $result = $this->providerService->updateStatus($id, $request->status, $comment);

        if ($result) {
            return redirect()->route('admin.providers.requests.index');
        }
    }
}
