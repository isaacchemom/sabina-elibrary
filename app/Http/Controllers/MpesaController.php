<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
//use Illuminate\Support\Facades\Session;
use Mpesa;
use App\Models\User;

use App\Models\Transaction;
use App\Models\Payment;
use App\Models\items;
use Str;
use Session;
use Mail;
use App\Mail\bookMail;
use Carbon\Carbon;

class MpesaController extends Controller
{
    public function processPayment(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'phoneNumber' => 'required|string',
            'cartItems' => 'required|string', // Ensure cartItems is passed as a JSON string
            'totalAmount' => 'required|numeric',
        ]);

        // Retrieve the data from the request
        $phone = $request->input('phoneNumber');
        $email = $request->input('email');
        $cartItemsJson = $request->input('cartItems');
        $totalAmount = $request->input('totalAmount');

        // Decode the cart items from JSON string to PHP array
        $cartItems = json_decode($cartItemsJson, true);

        // Format the total amount
        $formattedPrice = number_format($totalAmount, 0, '', '');

        // Generate a unique transaction ID
        $transId = Str::random() . $phone . $formattedPrice;
        // Store the phone number in the session
        session(['phoneNumber' => $phone]);

        $transexists = Transaction::where('phone', $phone)->where('status', 'cart')->first();


        $oneMinuteAgo = Carbon::now()->subMinutes(1);

        // Get all transactions that match the criteria
        $transi = Transaction::where('created_at', '<', $oneMinuteAgo)
            ->where('status', 'cart')->get();

        // Check if any transactions were found
        if ($transi->isNotEmpty()) {
            // Loop through each transaction and update its status
            foreach ($transi as $transaction) {
                $transaction->status = 'Incompleted';
                $transaction->save();
            }
        }

        if ($transexists) {


            return response()->json(['error' => 'You still have a pending transaction  wait for one minute and try again']);
        }


        // Process each item in the cart
        foreach ($cartItems as $key => $item) {
            $trans = new Transaction;

            // Save individual transaction details for each item
            $trans->phone = $phone;
            $trans->email = $email;
            $trans->transaction_id = $transId;
            $trans->item_id = $key; // Using the array key as a unique identifier
            $trans->status = 'cart';
            // $trans->item_quantity = $item['quantity'];
            // $trans->item_price = $item['price'];
            // $trans->total_price = $item['quantity'] * $item['price'];
            //$trans->img_path = $item['img_path'] ?? null; // Handle the case where img_path might be null

            // Save the transaction to the database
            $trans->save();
        }

        // Format the phone number for international use
        $formatedPhone = substr($phone, 1); // Remove the leading '0' (e.g., 726582228)
        $phoneNumber = "254" . $formatedPhone; // Prepend the country code (e.g., 254726582228)
        // Return a response (e.g., redirect to a success page or return JSON)

        //start of function call to initiate mpesa payment

        $mpesa = new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode = 6812038;
        //$LipaNaMpesaPasskey=env('MPESA_PASS_KEY');
        $LipaNaMpesaPasskey = '7bfdf163449b2aeac8066daec20c77ffc33529f61906e513b1065fef1c06782b';

        // $TransactionType="CustomerPayBillOnline";
        $TransactionType = "CustomerBuyGoodsOnline";
        $Amount = $formattedPrice;
        $PartyA = $phoneNumber;
        $PartyB = 4311968;
        $PhoneNumber = $phoneNumber;
        $CallBackURL = "https://sabin-elibrary.co.ke/api/mpesa/stkpush/response";
        $AccountReference = "Sabina books";
        $TransactionDesc = "lipa Na M-PESA web development";
        $Remarks = "Thank for paying!";

        $stkPushSimulation = $mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        Log::info($stkPushSimulation);
        $decoded_res = json_decode($stkPushSimulation);

        if (isset($decoded_res->errorCode)) {
            // An error occurred
            $message = $decoded_res->errorMessage ?? 'An error occurred';
            $data = ['status' => 'error', 'message' => $message, 'error_code' => $decoded_res->errorCode];
            return response()->json([
                'error' => 'MPESA FAILED TO INITIALIZE',
                'data'  => $data // Assuming $data is the additional information you want to include
            ]);
        }

        $transactionIds = []; // Array to store transaction IDs

        foreach ($cartItems as $key => $item) {
            // Create a new Payment record for each item
            $mpesa_transaction = new Payment;
            $mpesa_transaction->phone = $phoneNumber;
            $mpesa_transaction->amount = $item['price']; // Amount for the item
            // $mpesa_transaction->trans_id = $transId; // Transaction ID
            $mpesa_transaction->bookId = $key; // Item ID (or any unique identifier for the item)

            // Assign additional payment information
            $mpesa_transaction->MerchantRequestID = $decoded_res->MerchantRequestID ?? null;
            $mpesa_transaction->CheckoutRequestID = $decoded_res->CheckoutRequestID ?? null;

            // Save the payment record to the database
            $mpesa_transaction->save();

            // Store the ID of the saved transaction
            $transactionIds[] = $mpesa_transaction->id;
        }

        // Retrieve the last saved transaction ID (or any specific ID as needed)
        $lastTransactionId = end($transactionIds);
        $phone = session('phoneNumber', null);
        // Retrieve the specific transaction
        $lastTransaction = Payment::find($lastTransactionId);

        // Return the response with the specific transaction
        return response()->json([
            'success' => 'Please check your phone for the M-PESA prompt and enter your PIN to complete payment!',
            'transaction' => $lastTransaction // Return the specific transaction
        ]);
    }


    public function checkPaymentStatus(Request $request)
    {



        $CheckoutRequestID = $request->CheckoutRequestID;
        $MerchantRequestID = $request->MerchantRequestID;

        // Retrieve the transaction
        $transaction = Payment::where('MerchantRequestID', $MerchantRequestID)
            ->where('CheckoutRequestID', $CheckoutRequestID)
            ->first();

        // Check if the transaction exists and its status
        if ($transaction) {
            if ($transaction->status == 'paid') {
                return response()->json([
                    'status' => $transaction->status,
                    'success' => 'Transaction completed successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => $transaction->status,
                    'success' => 'Transaction pending!'
                ]);
            }
        } else {
            return response()->json([
                'status' => 'not_found',
                'success' => 'Transaction not found!'
            ]);
        }
    }


    public function stkSimulation(Request $request, $bookId, $bookPrice)
    {
        //$user = User::find($user_id);
        $item = items::find($bookId);
        //  $item_file_path=$item->file_path;

        //$cart = \Cart::getContent();

        if ($request->email !== $request->email_confirmation) {
            //return response()->json(['error' => '.'], 422);
            //session()->flash('error','Email confirmation does not match please try again! !');
            return response()->json(['error' => 'Email confirmation does not match please check and try again! ']);
            // return back();
            //  return redirect('/confirmation');
            //return back()->with('error', 'Email confirmation does not match please try again!');
        }

        $myphone = $request->phone;
        $myemail = $request->email;

        $formattedPrice = number_format($bookPrice, 0, '', '');

        $transId = Str::random() . $bookId . $formattedPrice;
        $transexists = Transaction::where('phone', $myphone)->where('status', 'Pending')->first();

        $oneMinuteAgo = Carbon::now()->subMinutes(1);
        $mytrans = Transaction::where('created_at', '<', $oneMinuteAgo)->where('status', 'Pending')->first();
        if ($mytrans !== null) {
            $mytrans->status = 'Incomplete';
            $mytrans->save();
        }

        if ($transexists) {
            //session()->flash('error','You still have a pending transaction  wait for 5 minutes and try again!');
            //return back();

            return response()->json(['error' => 'You still have a pending transaction  wait for one minute and try again']);
        }



        //
        $trans = new Transaction;
        //$trans->user_id = $user_id;
        $trans->phone = $myphone;
        $trans->email = $myemail;
        $trans->transaction_id = $transId;
        //$trans->cart = json_encode($cart);

        $trans->item_id = $bookId;
        $trans->save();


        $phone = $myphone;
        $formatedPhone = substr($phone, 1); //726582228
        $code = "254";
        $phoneNumber = $code . $formatedPhone; //254726582228


        //start of function call to initiate mpesa payment

        $mpesa = new \Safaricom\Mpesa\Mpesa();
        $BusinessShortCode = 6812038;
        //$LipaNaMpesaPasskey=env('MPESA_PASS_KEY');
        $LipaNaMpesaPasskey = '7bfdf163449b2aeac8066daec20c77ffc33529f61906e513b1065fef1c06782b';

        // $TransactionType="CustomerPayBillOnline";
        $TransactionType = "CustomerBuyGoodsOnline";
        $Amount = $formattedPrice;
        $PartyA = $phoneNumber;
        $PartyB = 4311968;
        $PhoneNumber = $phoneNumber;
        $CallBackURL = "https://sabin-elibrary.co.ke/api/mpesa/stkpush/response";
        // $CallBackURL = "https://c2e4-102-213-241-198.ngrok-free.app/api/mpesa/stkpush/response";
        $AccountReference = "Sabina books";
        $TransactionDesc = "lipa Na M-PESA web development";
        $Remarks = "Thank for paying!";

        $stkPushSimulation = $mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        // return  $stkPushSimulation;


        // Return a response message
        return response()->json([
            'message' => 'Check your phone for the M-PESA prompt to enter your PIN...After Payment  check your email for your item',
        ]);
    }

    public function checkPayment(Request $request)
    {
        $mpesaTransactionId = $request->input('mpesaTransactionId');
        //$formatedPhone = $request->input('formatedPhone');

        //$trans = Transaction::with('items')->where('phone', $formatedPhone)->where('status', 0)->first();

        $payment = Payment::with('transaction.items')->where('mpesa_trans_id', $mpesaTransactionId)


            ->first();

        // dd($payment);


        if ($payment) {

            $transaction = $payment->transaction;
            $item = $transaction ? $transaction->items : null;
            // dd($item);

            // Construct file path
            $file_path = $item->file_path ? asset('/' . $item->file_path) : null;
            $ms_path = $item->ms_path ? asset('/' . $item->ms_path) : null;

            return response()->json([
                'success' => true,
                'message' => 'Payment found.',
                'file_path' => $file_path,
                'ms_path' => $ms_path,
                'name' => $item->title,
                'payment' => $payment,
                'transaction' => $transaction,
                'item' => $item
            ]);
        } else {
            // Return JSON response if payment does not exist
            return response()->json([
                'success' => false,
                'message' => 'Payment record not found try again or contact us for assistance.'
            ]);
        }
    }



    public function resData(Request $request)
    {

        $response = json_decode($request->getContent());
        Log::info(json_encode($response));
        $resData =  $response->Body->stkCallback->CallbackMetadata;
        $reCode = $response->Body->stkCallback->ResultCode;
        $resMessage = $response->Body->stkCallback->ResultDesc;
        $amountPaid = $resData->Item[0]->Value;
        $mpesaTransactionId = $resData->Item[1]->Value;
        $paymentPhoneNumber = $resData->Item[4]->Value;
        $paymentDate = $resData->Item[3]->Value;
        //replace the first 254 with 0
        $formatedPhone = str_replace("254", "0", $paymentPhoneNumber);
        //$user = transanction::where('phone', $formatedPhone)->first();

        $trans = Transaction::where('phone', $formatedPhone)->where('status', 'Pending')->first();

        if (!$trans) {
            $trans = Transaction::where('phone', $formatedPhone)->where('status', 'cart')->get();


            // Check if transactions were found
            if ($trans->isNotEmpty()) {
                foreach ($trans as $mytrans) {
                    $transId = $mytrans->id;
                    $myitemid = $mytrans->item_id;

                    // Find the item associated with the transaction
                    $item = items::find($myitemid);

                    if ($item) {
                        // $item_file_path = $item->file_path;
                        // $ms_path = $item->ms_path;
                        //  $title = $item->title;
                        // $desc = $item->desc;
                        // $email = $mytrans->email;

                        // Create a new payment record


                        //  $payment->amount = $amountPaid;
                        //  $payment->trans_id = $transId;
                        //$payment->mpesa_trans_id = $mpesaTransactionId;
                        //$payment->phone = $formatedPhone;
                        // $payment->bookId = $myitemid;

                        if ($mpesaTransactionId) {
                            $trans = Payment::where('phone', $formatedPhone)
                                ->where('status', 'pending')
                                ->update([
                                    'status' => 'paid',
                                    'trans_id' => $transId,
                                    'mpesa_trans_id' => $mpesaTransactionId
                                ]);

                            $mytrans->status = 'Paid';
                            $mytrans->save();
                        }


                        // Update the transaction status to 'Paid'

                    }
                }
            }
        } else {
            // $trans = Transaction::with('items')->where('phone', $formatedPhone)->where('status', 0)->first();

            $transId = $trans->id;
            $myitemid = $trans->item_id;

            $item = items::find($myitemid);
            // $item=$item->file_path;
            $item_file_path = $item->file_path;
            $ms_path = $item->ms_path;

            $title = $item->title;
            $desc = $item->desc;
            $email = $trans->email;


            $payment = new Payment;
            $payment->amount = $amountPaid;
            $payment->trans_id = $transId;
            // $payment->user_id = $user->id;
            // $payment->user_id = 1;
            $payment->mpesa_trans_id = $mpesaTransactionId;
            $payment->phone = $formatedPhone;
            // $payment->bookId=1;
            $payment->bookId = $myitemid;

            // Check if mpesa_trans_id already exists in the database
            $existingPayment = Payment::where('mpesa_trans_id', $mpesaTransactionId)->first();

            if (!$existingPayment) {
                // mpesa_trans_id does not exist, so save the new payment
                $payment->save();
            }

            $trans->status = 'Paid';
            $trans->save();




            $payment = Payment::where('mpesa_trans_id', $mpesaTransactionId)->where('phone', $formatedPhone)->first();



            if ($payment) {
                $fileTittle = $title;
                $mailData = [
                    'title' => $title,
                    'body' => $desc,
                ];

                // Prepare the attachments array
                $attachments = [
                    public_path($item_file_path)
                ];

                // Add the ms_path to the attachments if it exists
                if (!empty($ms_path)) {
                    $attachments[] = public_path($ms_path);
                }

                // Send the email with multiple attachments
                Mail::to($email)->send(new bookMail($mailData, $fileTittle, $attachments));

                return redirect('/download')->with('success', 'Email sent successfully! Check your email for the item.')->with('file_path', $item_file_path);
            }
        }
    }
}
