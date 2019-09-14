@extends('layouts.master')

@section('title', 'Facility Types')

@section('content')
<account-component inline-template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
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
                      <th>Balance</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                    <tr v-for="account in accounts" v-bind:key="account.id">
                      <td v-text="account.account_id"></td>
                      <td v-text="account.balance"></td>
                      <td style="width: 40px">
                        <button>aaa</button>
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
