<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Transaction Form</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form v-on:submit.prevent class="form-horizontal">
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Select Account</label>

          <div class="col-sm-10">
            <select v-model="transaction.account_id" class="form-control" >
              <option disabled value="">Please select one</option>
              @foreach($accounts as $account)
              <option value="{{ $account->account_id }}">{{ $account->account_name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Trsansaction to</label>

          <div class="col-sm-10">
            <input v-model="transaction.transaction_to" type="text" class="form-control" placeholder="Transaction To" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Amount</label>

          <div class="col-sm-10">
            <input v-model="transaction.amount" type="text" class="form-control" placeholder="Amount" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Remarks</label>

          <div class="col-sm-10">
            <input v-model="transaction.remarks" type="text" class="form-control" placeholder="Remarks" required="">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button @click="closeTransactionForm()" type="submit" class="btn btn-default pull-right">Cancel</button>
        <button type="submit" style="margin-right: 10px" class="btn btn-info pull-right" @click="saveTransaction()">Save Transaction</button>
      </div>
    </form>
  </div>
  <!-- /.box -->
  
</div>