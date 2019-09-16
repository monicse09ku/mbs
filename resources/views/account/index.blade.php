@extends('layouts.master')

@section('title', 'Accounts')

@section('content')
<account-component inline-template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                  <button v-if="!showAccountForm" type="button" class="btn btn-primary pull-right" @click="toggoleAccountForm()">
                    Add Account
                  </button>

                  <div v-if="showAccountForm">
                    
                    @include('account.form')
                  </div>

                    <h1 class="card-header">Accounts</h1>

                    <div class="card-body">
                        
                        <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Accounts Table</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                          <table class="table table-striped">
                            <tr>
                              <th>Account Id</th>
                              <th>Account Name</th>
                              <th>Account Desc</th>
                              <th>Balance</th>
                              <th style="width: 40px">Actions</th>
                            </tr>
                            <tr v-for="account in accounts">
                              <td v-text="account.account_id"></td>
                              <td v-text="account.account_name"></td>
                              <td v-text="account.account_desc"></td>
                              <td v-text="account.balance"></td>
                              <td>
                                <button style="margin-bottom: 5px" @click="EditAccount(account)" class="btn btn-warning"><i class="fa fa-edit"></i></button>
                                <button @click="deleteAccount(account.id)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                              </td>
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


</account-component>



@endsection
