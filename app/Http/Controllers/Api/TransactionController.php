<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TransactionResource;
use App\Models\Transaction;
use App\Models\Account;
use App\User;
use Auth, DB;
use Illuminate\Support\Facades\Hash;

class TransactionController extends ApiBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::where('user_id', auth()->user()->id)->pluck('account_id')->toArray();

        $transactions = Transaction::whereIn('account_id', $accounts)->orWhereIn('transaction_to', $accounts)->paginate(request('limit') ?? 10);

        foreach ($transactions as $transaction) {
            if(in_array($transaction->transaction_to, $accounts)){
                $transaction->transaction_type = 'deposit';
            }
        }
            
        return TransactionResource::collection($transactions);
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

        if($request->account_id == $request->transaction_to){
            return $this->respondInternalError('You can not transfer to same account');
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

                Account::where('account_id', $request->account_id)->update([
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
        $account = Account::where('account_id', $account_id)->first();
        
        return ($account->balance - $balance);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        return Auth::user();
    }

    public function userUpdate(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError('Parameters failed validation');
        }

        $user['name'] = $request->name;
        $user['email'] = $request->email;
        if(!empty($request->password)){
            $user['password'] =  Hash::make($request->password);
        }

        try {
            DB::table('users')
            ->where('id', 1)
            ->update($user);

            return $this->respondSuccess('SUCCESS');

        } catch (\Exception $e) {
            return $this->respondInternalError($e->getMessage());
        }
    }
}
