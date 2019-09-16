<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Transaction;
use App\Models\Account;
use Auth, DB;

class TransactionController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TransactionResource::collection(Transaction::paginate(request('limit') ?? 10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'account_id' => 'required',
            'transaction_to' => 'required',
            'amount' => 'required',
            'remarks' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError('Parameters failed validation');
        }

        $to_account = Account::where('account_id', $request->transaction_to)->first();
        if(empty($to_account)){
            return $this->respondInternalError('Invalid Account');
        }

        $revised_balance = $this->insufficientBalance($request->account_id, $request->amount);
       
        if($revised_balance < 0){
            return $this->respondValidationError('Insufficient Balance');
        }

        try{
            DB::transaction(function () use ($request, $revised_balance){
                Transaction::create([
                        'account_id' => $request->account_id,
                        'transaction_to' => $request->transaction_to,
                        'transaction_type' => 'transfer',
                        'amount' => $request->amount,
                        'remarks' => $request->remarks
                    ]);

                Account::where('id', $request->account_id)->update([
                    'balance' => $revised_balance
                ]);

                $transaction_to_account = Account::where('account_id', $request->transaction_to)->first();

                $transaction_to_account->balance = $transaction_to_account->balance + $request->amount;

                $transaction_to_account->save();
            });

            return $this->respondSuccess('SUCCESS');
        }catch(Exception $e){
            return $this->respondInternalError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function insufficientBalance($account_id, $balance)
    {
        $account = Account::where('id', $account_id)->first();
        
        return ($account->balance - $balance);
    }
}
