<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\PurchaseModel;
use App\Models\Api\SalesModel;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Exception;

class StripeController extends Controller
{
    // create 
    public function payment(Request $request){
        $request->validate(['purchase_id'=>'required:purchase,id',]);


        try{
            $purchase =PurchaseModel::findOrfail($request->purchase_id);

            if($purchase->payment_status=='paid'){
                return response()->json([
                'status'=>true,
                'message'=>'This purchase item already paid',
                ],203);
            }

            Stripe::setApiKey(config('services.stripe.secret'));

            $paymentintent=PaymentIntent::create([
                'amount'=>(int)($purchase->grant_total * 100),
                'currency'=>'inr',
                'metadata'=>[
                    'purchase_id'=>$purchase->id,
                    'purchase_code'=>$purchase->code,
                    'user_id'=>$purchase->user_id,
                ],
            ]);

            $purchase->payment_intent_id=$paymentintent->id;
            $purchase->save();

            return response()->json([
                'status'=>true,
                'message'=>'payment create success',
                'purchase_id'=>$purchase->id,
                'purchase_code'=>$purchase->purchase_code,
                'paymentintent_id' => $paymentintent->id,
                'amount' => $purchase->amount,
                'client_secret' =>$paymentintent->client_secret,
                ],200);

        }catch(Exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
                ],500);
        }
        
    }
    // success 
    public function paymentsuccess(Request $request){
         $request->validate(['payment_intent_id'=>'required']);
         $purchase = PurchaseModel::where( 'payment_intent_id',$request->payment_intent_id)->first();

         if(!$purchase){
            return response()->json([
                'status'=>false,
                'message'=>'Purchase not found',
            ],404);
         }

         $purchase->payment_status="paid";
         $purchase->save();

         return response()->json([
                'status'=>true,
                'message'=>'Payment Sucessful',
                'purchase'=>$purchase
            ],200);
    }

    // failure
      public function paymentfail(Request $request){
         $request->validate(['payment_intent_id'=>'required']);
         $purchase = PurchaseModel::where( 'payment_intent_id',$request->payment_intent_id)->first();

         if(!$purchase){
            return response()->json([
                'status'=>false,
                'message'=>'Purchase not found',
            ],404);
         }

         $purchase->payment_status="failed";
         $purchase->save();

         return response()->json([
                'status'=>true,
                'message'=>'Payment Failed',
            ],404);


    }

       public function paymentdetail(Request $request){
         $request->validate(['user_id'=>'required']);
         $purchase = PurchaseModel::where( 'user_id',$request->user_id)->first();

         $remaining= $purchase->amount -  $purchase->grant_total;

         if(!$purchase){
            return response()->json([
                'status'=>false,
                'message'=>'This user Purchase not found',
            ],404);
         }
         return response()->json([
                'status'=>true,
                'message'=>'Payment Deatils',
                'payment_details'=>$purchase,
                'remaining'=>$remaining
            ],404);


    }

    // Sales payment

    public function paymentsales(Request $request){
        $request->validate([
            'sales_id'=>'required','paid_amount'=>'required|numeric|min:0',
        ]);
        try{
            $sales = SalesModel::findOrfail($request->sales_id);

            if(!$sales){
                 return response()->json([
                'status'=>false,
                'message'=>'Sales data Not found',
                ],404);
            }

            if($request->paid_amount > $sales->balance_amount){
                 return response()->json([
                'status'=>false,
                'message'=>'Given amount is higher',
                ],404);
            }
             Stripe::setApiKey(config('services.stripe.secret'));

            $paymentintent=PaymentIntent::create([
                'amount'=>(int)($request->paid_amount * 100),
                'currency'=>'inr',
                'metadata'=>[
                    'sales_id'=>$sales->id,
                    'purchase_code'=>$sales->code,
                    'user_id'=>$sales->user_id,
                ],
            ]);

            $sales->payment_intent_id=$paymentintent->id;
            $sales->paid_amount=   $request->paid_amount;
            $sales->balance_amount =$sales->round_off - $request->paid_amount;
            $sales->save();

            return response()->json([
                'status'=>true,
                'message'=>'payment create success',
                'sales_id'=>$sales->id,
                'sales_code'=>$sales->sales_code,
                'paymentintent_id' => $paymentintent->id,
                'total' =>$sales->total,
                'round_off' =>$sales->round_off,
                'paid_amount' => $request->paid_amount,
                'balance_amonut'=>$sales->round_off - $request->paid_amount,
                'client_secret' =>$paymentintent->client_secret,
                ],200);

        }catch(Exception $e){
             return response()->json([
                'status'=>false,
                'message'=>$e->getMessage(),
                ],500);
        }
    }

       public function payment_success_sales(Request $request){
         $request->validate(['payment_intent_id'=>'required']);
         $sales = SalesModel::where( 'payment_intent_id',$request->payment_intent_id)->first();

         if(!$sales){
            return response()->json([
                'status'=>false,
                'message'=>'sales not found',
            ],404);
         }

         $sales->payment_status="paid";
         $sales->save();

         return response()->json([
                'status'=>true,
                'message'=>'sales Sucessful',
                'sales'=>$sales
            ],200);
    }



}
    