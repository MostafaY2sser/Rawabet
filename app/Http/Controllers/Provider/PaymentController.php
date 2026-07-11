<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use App\Models\Provider;
use App\Services\Provider\PaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $provider = Provider::findOrFail(auth('provider')->id());

        $payments = $this->paymentService->getAllPayments(
            $provider,
            $request->get('status'),
            $request->get('search')
        );

        return view('provider.payments.index', $payments);
    }

    public function show($id)
    {
        $payment = $this->findPaymentForProvider($id);

        return view('provider.payments.show', compact('payment'));
    }

    public function download($id)
    {
        $payment = $this->findPaymentForProvider($id);
        $filename = 'invoice-' . ($payment->transaction_reference ?: $payment->id) . '.html';

        return response()
            ->view('payments.invoice-download', compact('payment'))
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    private function findPaymentForProvider(int $id): PaymentTransaction
    {
        $payment = PaymentTransaction::with([
            'contract.offer.project',
            'payementStage',
            'sender',
            'beneficiary',
        ])->findOrFail($id);

        if ($payment->beneficiary_type !== Provider::class || (int) $payment->beneficiary_id !== (int) auth('provider')->id()) {
            abort(404);
        }

        return $payment;
    }
}
