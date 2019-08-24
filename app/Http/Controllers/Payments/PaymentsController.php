<?php

namespace App\Http\Controllers\Payments;

use App\Events\NewPaymentEvent;
use App\Events\PaymentNotVerifiedEvent;
use App\Events\PaymentVerifiedEvent;
use App\Events\RemovePaymentEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\PaymentVerifiedRequest;
use App\Invoice;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PaymentsController extends Controller
{

    public function showPaymentForm(Invoice $invoice){
        $route_name = (isClubLeader(Auth::user()))?'participation_event_list':'event_club_detail';

        $breadcrumb = collect([
            route('home') => 'Inicio',
            route('events_list') => 'Eventos',
            route('event_detail', $invoice->participation->event->id) => $invoice->participation->event->name,
            route('event_clubs', [$invoice->participation->event->id]) => 'Clubes inscritos',
            route($route_name,[$invoice->participation->event->id,$invoice->participation->club->id]) => $invoice->participation->club->name,
            'active' => 'Pagar'

        ]);


        $participant = $invoice->participation->event->participants()->where('eventable_id', $invoice->participation->club->id)->where('eventable_type','App\Club');
        if($participant->count() && $participant->first()->snapshot){
            $participants = getRegistrations($invoice->participation->event, $invoice->participation->club);
        }

        return view('modules.participation.payment', [
            'invoice' => $invoice,
            'payment_completed' => checkPayment($invoice),
            'participants' => $participants,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function savePayment(Request $request, Invoice $invoice){
        $payment = $invoice->payments()->create([
            'amount' => $request->amount
        ]);

        event(new NewPaymentEvent($payment));

        return response()->json([
            'error' => false,
            'data' => [
                'payment' => $payment
            ],
            'message' => 'Su pago se ha registrado con exito'
        ]);
    }

    public function uploadPayment(Request $request, Invoice $invoice){
        $file = $request->file('file');
        $base_derectory = 'public/';
        $local_derectory = 'payments';
        $file_name = Str::slug($file->getClientOriginalName()) . '.'. $file->getClientOriginalExtension();
        $local_path_to_file = $local_derectory . '/' . $file_name;
        $path = $file->storeAs($base_derectory . $local_derectory, $file_name);
        $file_path = storage_path('app/'.$path);

        $payment = $invoice->payments()->create([
            'amount' => $request->amount
        ]);
        event(new NewPaymentEvent($payment));

        if(checkPayment($payment->invoice)){
            $invoice->participation->status = 2;
            $invoice->participation->save();
        }

        $payment->voucher = $local_path_to_file;
        $payment->save();

        $payment->date = $payment->created_at->diffForHumans();
        $payment->amount = number_format($payment->amount,0,'.',',');

        return response()->json([
            'error' => false,
            'data' => [
                'payment' => $payment,
                'total_amount' => number_format($invoice->payments->sum('amount'),0,'.',','),
                'payment_completed' => checkPayment($payment->invoice),
                'file_path' => Storage::url($local_path_to_file)
            ],
            'message' => 'Su pago se ha registrado con exito'
        ]);
    }

    public function deletePayment(Request $request){
        $payment = Payment::find($request->payment_id);
        $invoice = $payment->invoice;
        $payment->delete();
        $sum = $invoice->payments->sum('amount');

        event(new RemovePaymentEvent($payment));

        if(!checkPayment($payment->invoice)){
            $invoice->participation->status = 1;
            $invoice->participation->save();
        }

        return response()->json([
            'error' => false,
            'total_amount' => number_format($sum,0,'.',','),
            'message' => 'Has eliminado un pago'
        ]);
    }

    public function paymentVerification(PaymentVerifiedRequest $request){
        $payment = Payment::find($request->payment_id)->verified();
        event( new PaymentVerifiedEvent($payment));

        return response()->json([
            'error' => false,
            'message' => "Ha verificado un pago equivalente a ". asMoney($payment->amount),
            'data' => [
                'payment' => $payment
            ]
        ]);
    }

    public function cancelPaymentVerification(PaymentVerifiedRequest $request){
        $payment = Payment::find($request->payment_id)->notVerified();
        event( new PaymentNotVerifiedEvent($payment));

        return response()->json([
            'error' => false,
            'message' => "Ha cancelado la verificación de un pago equivalente a ". asMoney($payment->amount),
            'data' => [
                'payment' => $payment
            ]
        ]);
    }

}