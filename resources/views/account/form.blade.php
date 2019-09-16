<div class="col-md-12">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Account Form</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form v-on:submit.prevent class="form-horizontal">
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
<input type="hidden" id="user_id" name="user_id" value="{{ auth()->user()->id }}">
          <div class="col-sm-10">
            <input v-model="account.account_name" type="text" class="form-control" placeholder="Account Name" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Description</label>

          <div class="col-sm-10">
            <input v-model="account.account_desc" type="text" class="form-control" placeholder="Description" required="">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button @click="closeAccountForm()" type="submit" class="btn btn-default pull-right">Cancel</button>
        <button type="submit" style="margin-right: 10px" class="btn btn-info pull-right" @click="saveAccount()">Save Account</button>
      </div>
    </form>
  </div>
  <!-- /.box -->
  
</div>