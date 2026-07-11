<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Offer;
use App\Models\PaymentTransaction;
use App\Services\Customer\ContractService;
use App\Services\Customer\PaymentService;
use App\Utils\OfferUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $contractService;

    public function __construct(PaymentService $paymentService, ContractService $contractService)
    {
        $this->contractService = $contractService;
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $customer = Customer::findOrFail(auth()->id());

        $payments = $this->paymentService->getAllPayments(
            $customer,
            $request->get('status'),
            $request->get('search')
        );

        return view('customer.payments.index', $payments);
    }

    public function show($id)
    {
        $payment = $this->findPaymentForCustomer($id);

        return view('customer.payments.show', compact('payment'));
    }

    public function download($id)
    {
        $payment = $this->findPaymentForCustomer($id);
        $filename = 'invoice-' . ($payment->transaction_reference ?: $payment->id) . '.html';

        return response()
            ->view('payments.invoice-download', compact('payment'))
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function depositePayment(Request $request)
    {
        DB::beginTransaction();

        try {
            $offer = Offer::findOrFail($request->offer_id);
            $contractTotalWithTax = OfferUtility::getDetails($offer)['total_amount_with_tax'];

            $contractData =
                ['offer_id' => $offer->id,
                    'deposit' => $request->amount,
                    'remaining' => $contractTotalWithTax - $request->amount,
                    'tax_percentage' => getTaxPercentage($offer),
                    'deposit_paid' => 1,
                    'mobile_verification' => 1234,
                    'reference' => uniqid('CNT_')
                ];

            $contract = $this->contractService->create($contractData);

            $depositeRecord = $offer->deposite();
            $depositeRecord->update(['status' => 'paid']);

            $paymentData = [
                'amount' => $request->amount,
                'payment_schedule_id' => $offer->deposite()->id,
                'contract_id' => $contract->id,
                'status' => 'hold',
                'transaction_reference' => uniqid(),
                'provider_id' => $offer->provider->id
            ];

            $this->paymentService->create($paymentData);
            DB::commit();

            return response(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response([
                'success' => false,
                'message' => 'Transaction failed',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function findPaymentForCustomer(int $id): PaymentTransaction
    {
        $payment = PaymentTransaction::with([
            'contract.offer.project',
            'payementStage',
            'sender',
            'beneficiary',
        ])->findOrFail($id);

        if ($payment->sender_type !== Customer::class || (int) $payment->sender_id !== (int) auth()->id()) {
            abort(404);
        }

        return $payment;
    }
}
