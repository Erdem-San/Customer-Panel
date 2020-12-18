@extends('back.layouts.master')
@section('title','Panel')
@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Data Panel</h1>
      <a href="{{route('admin.cancelpanel')}}" style="position: absolute; right:15px;" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
              class="fas fa-ban fa-sm text-white-50"></i> Canceled</a>
  </div>
<div  class="col-md-12" id="message"></div>

<div class="card shadow pt-3 mb-4 col-md-12">
    <div class="card-body">
      <div class="message d-none"></div>
      <div class="table-responsive">
      <table class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
      <thead>
          <tr>
              <th>Customer Name</th>
              <th>Website</th>
              <th>Ip</th>
              <th>Price</th>
              <th>Created At</th>
              <th>Action</th>
          </tr>
      </thead>
      <tbody>
        <form id="addForm">
          @csrf
          <tr>
            <td id="name">
              <select class="form-control">
                @foreach ($customers as $customer)
                    <option value="{{$customer->name}}">{{$customer->name}}</option>
                @endforeach
              </select>
            </td>
            <td class="editableTd" contenteditable id="email"></td>
            <td class="editableTd" contenteditable id="ip"></td>
            <td class="editableTd" contenteditable id="prix"></td>
            <td>
              <input type="date" id="created_at" class="form-control">
            </td>
            <td> <button type="submit" name="button" id="btn_add" class="btn btn-success">Add</button> </td>
          </tr>
        </form>
      </tbody>
    </table>
  </div>
        <div class="table-responsive">
            <table class="table mainTable table-striped table-bordered dt-responsive nowrap" id="datatable" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Website</th>
                        <th>Ip</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <form method="post">
                <tbody>
                  @csrf

                </tbody>
                </form>
            </table>
        </div>
    </div>
</div>

@endsection
@section('css')
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
  <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <style media="screen">
    .btn-danger:not(:disabled):not(.disabled).active, .btn-danger:not(:disabled):not(.disabled):active, .show>.btn-danger.dropdown-toggle {
      background-color: #e74a3b;
      border-color: #e74a3b;
      }
      .editColor{
        background-color: purple;
        margin-top: 1px!important;
        box-shadow:
           0 2.8px 2.2px rgba(0, 0, 0, 0.034),
           0 6.7px 5.3px rgba(0, 0, 0, 0.048),
           0 12.5px 10px rgba(0, 0, 0, 0.06),
           0 22.3px 17.9px rgba(0, 0, 0, 0.072),
           0 41.8px 33.4px rgba(0, 0, 0, 0.086),
           0 100px 80px rgba(0, 0, 0, 0.12);
        border-color: purple;
       }
       .newDeleteBtn{
         margin-bottom:2px!important;
       }

      .editColor:focus{
        background-color: purple;
        margin-top: 1px!important;
        box-shadow:
           0 2.8px 2.2px rgba(0, 0, 0, 0.034),
           0 6.7px 5.3px rgba(0, 0, 0, 0.048),
           0 12.5px 10px rgba(0, 0, 0, 0.06),
           0 22.3px 17.9px rgba(0, 0, 0, 0.072),
           0 41.8px 33.4px rgba(0, 0, 0, 0.086),
           0 100px 80px rgba(0, 0, 0, 0.12);
        border-color: purple;
       }

      .editFocus{
        background: #8000808c;
        color:white;
      }
      .bg-purple {
        background: #a93be7;
      }

  </style>
@endsection
@section('js')
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script>
  $(function() {
    $('#datatable').DataTable({
        aaSorting: [[0, 'desc']],
        processing: true,
        language: { processing: 'Loading <i class="fa fa-spinner fa-spin fa-fw"></i><span class="sr-only">Loading...</span> '},
        serverSide: true,
        ajax: '{!! route('admin.ajax.data') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'ip', name: 'ip' },
            { data: 'prix', name: 'prix' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action' }
          ],
          "fnDrawCallback": function() {
            $('.switch').bootstrapToggle();
          }
        });

        $('#btn_add').on('click', function(e){
          e.preventDefault();
          var name = $('#name select').val();
          var email = $('#email').text();
          var ip = $('#ip').text();
          var prix = $('#prix').text();
          var _token= $('input[name=_token]').val();
          if(email == '' || ip == '' || prix == '')
          {
            $("#message").html('<div class="alert alert-danger">Don\'t leave empty field!</div>').show().delay(1500).fadeOut('slow');
            return false;
          }
          if($('#created_at').val() == "" || $('#created_at').val() == null){
            var currentdate = new Date();
            var created_at = currentdate.getFullYear() + "-"
                + (currentdate.getMonth()+1)+ "-"
                + currentdate.getDate() + " "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();
          } else {
            var created_at = $('#created_at').val();
          }
          $.ajax({
            url:"{{route('admin.ajax.insert')}}",
            method:"POST",
            data:{
              name:name,
              email:email,
              ip:ip,
              prix:prix,
              created_at:created_at,
              _token:_token
            },
            success:function(response){
              $('#datatable').DataTable().ajax.reload();
              $('.editableTd').empty();
              $("#message").html('<div class="alert alert-success col-md-3">Added successfully</div>').show().delay(1500).fadeOut('slow');
            }
          })
        });

    });
</script>
<script type="text/javascript">
  $(function(){
    $('#datatable').on('click', '.toggle-group', function(){
        $('.switch').change(function(){
          id=$(this).attr('data');
          statu=$(this).prop('checked');
          $.get("{{route('admin.switch')}}", {id:id,statu:statu}, function(data, status){
          });
        });
    });
    $('#datatable tbody tr td:first').append('a');
    $('#datatable').on('click', '.editBtn',function(){
      $(this).parent('td').find('.deleteBtn').addClass('newDeleteBtn');
      var type = $(this).attr('type');
      var dateInput= $(this).parent('td').parent('tr').find('td .progress input').show();
      var progresBar = $(this).parent('td').parent('tr').find('td .progress .progress-bar').hide();
      if (type!='submit') {
        $(this).prop('type', 'submit');
      }
      $(this).addClass('editColor').html('Update');
      $(this).parent('td').parent('tr').find('td:lt(5):not(:first)').attr('contenteditable','true');
      $(this).parent('td').parent('tr').find('td').addClass('editFocus');
      $(this).parent('td').append('<button style="border-radius:50%;padding:5px 10px;" class="btn btn-secondary cancelEdit btn-sm ml-2 mt-1"><i class="fa fa-times"></i></button>');
      $('#datatable').on('click', '.editColor', function(e){
        e.preventDefault();
        var name = $(this).parent('td').parent('tr').find('td:eq(1)').text();
        var email = $(this).parent('td').parent('tr').find('td:eq(2)').text();
        var ip = $(this).parent('td').parent('tr').find('td:eq(3)').text();
        var prix = $(this).parent('td').parent('tr').find('td:eq(4)').text();
        var created_at = $(this).parent('td').parent('tr').find('td:eq(6) input').val();
        var _token= $('input[name=_token]').val();
        var id = $(this).attr('id');
        if(name == '' || email == '' || prix == '')
        {
          $("#message").html('<div class="alert alert-danger">Don\'t leave empty field!</div>').show().delay(1500).fadeOut('slow');
          return false;
        }
        var created_at = $(this).parent('td').parent('tr').find('td:eq(6) input').val();

        if (created_at == '' || created_at == null) {
          var created_at = $(this).parent('td').parent('tr').find('td:eq(6) input').attr('data');
        } else {
          var created_at = $(this).parent('td').parent('tr').find('td:eq(6) input').val();
        }
        $(this).parent('td').find('.cancelEdit').remove();
          $.ajax({
          url:"{{route('admin.ajax.update')}}",
          method:"POST",
          data:{
            id:id,
            name:name,
            email:email,
            ip:ip,
            prix:prix,
            created_at:created_at,
            _token:_token
          },
          success:function(response){
            $('#datatable').DataTable().ajax.reload();
            $("#message").html('<div class="alert alert-success col-md-3">Updated successfully</div>').show().delay(1500).fadeOut('slow');
          }
        })

      });
    });
    $('#datatable').on('click', '.cancelEdit', function(){
      $(this).parent('td').find('.deleteBtn').addClass('newDeleteBtn');
      $(this).parent('td').parent('tr').find('td:lt(5):not(:first)').attr('contenteditable','false');
      $(this).parent('td').parent('tr').find('td').removeClass('editFocus');
      $(this).parent('td').find('.editBtn').removeClass('editColor').prop('type', 'button').css('margin-top','2px').html('Edit');
      $(this).parent('td').parent('tr').find('td .progress input').hide();
      var progresBar = $(this).parent('td').parent('tr').find('td .progress .progress-bar').show();
      $(this).remove();
    });
  });
</script>
<script type="text/javascript">
  $(function(){
      $('#datatable').on('click', '.deleteBtn', function(){
        if (confirm("İptal etmek istediğinizden eminmisiniz?")==true) {
          var id = $(this).attr('id');
          var ip = $(this).attr('data');
          $.get("{{route('admin.ajax.delete')}}", {id:id,ip:ip}, function(data){
            $('#datatable').DataTable().ajax.reload();
            $("#message").html('<div class="alert alert-info col-md-3">Data has been sent to Canceled.</div>').show().delay(1500).fadeOut('slow');
          });
        }
        return false;
      });
  })
</script>

@endsection
