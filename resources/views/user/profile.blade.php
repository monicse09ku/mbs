@extends('layouts.master')

@section('title', 'Profile')

@section('content')
<user-component inline-template>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
  <!-- Horizontal Form -->
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Udpate Profile</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    <form v-on:submit.prevent class="form-horizontal">
      <div class="box-body">
        <div class="form-group">
          <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
          <div class="col-sm-10">
            <input v-model="name" type="text" class="form-control" placeholder="Account Name" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Email</label>

          <div class="col-sm-10">
            <input v-model="email" type="text" class="form-control" placeholder="Description" required="">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

          <div class="col-sm-10">
            <input v-model="password" type="password" class="form-control" placeholder="Description">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password</label>

          <div class="col-sm-10">
            <input v-model="confirmPassword" type="password" class="form-control" placeholder="Description">
          </div>
        </div>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" style="margin-right: 10px" class="btn btn-info pull-right" @click="saveUser()">Save Account</button>
      </div>
    </form>
  </div>
  <!-- /.box -->
  
</div>
        </div>
    </div>


</user-component>



@endsection
