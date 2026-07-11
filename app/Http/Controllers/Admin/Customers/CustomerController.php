<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Enums\CustomerStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Services\Admin\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use PDO;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function index(Request $request)
    {
        if (!Auth::user('admin')->can('view customers'))
            abort(403);
        if ($request->ajax()) {
            $requests = $this->customerService->getActiveCustomers();
            // make sure getRequestsQuery() returns a query builder, not a collection

            return DataTables::of($requests)
                ->addColumn('status', function ($row) {
                    return \App\Enums\CustomerStatus::getLabel($row->status);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('view customers.requests')) {
                        $btn .= '<a href="' . route('admin.customers.show', $row->id) . '">
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

        return view('admin.customers.index');
    }

    public function requests(Request $request)
    {
        if (!Auth::user('admin')->can('view customers.requests'))
            abort(403);
        if ($request->ajax()) {
            $requests = $this->customerService->getRequestsQuery();
            // make sure getRequestsQuery() returns a query builder, not a collection

            return DataTables::of($requests)
                ->addColumn('status', function ($row) {
                    return \App\Enums\CustomerStatus::getLabel($row->status);
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('view customers.requests')) {
                        $btn .= '<a href="' . route('admin.customers.requests.edit', $row->id) . '">
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

        return view('admin.customers.requests.index');
    }

    public function show($id)
    {
        $customer = Customer::find($id);
        return view('admin.customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $request = Customer::find($id);
        return view('admin.customers.requests.edit', compact('request'));
    }

    public function updateStatus($id, Request $request)
    {
        // return $request->all();
        $request->validate(['status' => 'required|in:active,pending,require_update']);
        $comment = $request->msg ?? '';
        $result = $this->customerService->updateStatus($id, $request->status, $comment);

        if ($result) {
            return redirect()->route('admin.customers.requests.index');
        }
    }
}
