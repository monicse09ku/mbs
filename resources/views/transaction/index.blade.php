@extends('layouts.master')

@section('title', 'Transactions')

@section('content')
<transaction-component inline-template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                  <button v-if="!showTransactionForm" type="button" class="btn btn-primary pull-right" @click="toggoleTransactionForm()">
                    Add Transaction
                  </button>

                  <div v-if="showTransactionForm">
                    
                    @include('transaction.form')
                  </div>

                    <h1 class="card-header">Transactions</h1>

                    <div class="card-body">
                        
                        <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Transactions Table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <table class="table table-striped">
                            <tr>
                              <th>Account Id</th>
                              <th>Transaction To</th>
                              <th>Transaction Type</th>
                              <th>Amount</th>
                              <th>Remarks</th>
                            </tr>
                            <tr v-for="transaction in transactions">
                              <td v-text="transaction.account_id"></td>
                              <td v-text="transaction.transaction_to"></td>
                              <td v-text="transaction.transaction_type"></td>
                              <td v-text="transaction.amount"></td>
                              <td v-text="transaction.remarks"></td>
                            </tr>
                            
                          </table>
                        </div>
                        <!-- /.box-body -->
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</transaction-component>



@endsection
