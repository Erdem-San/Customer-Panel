@extends('back.layouts.master')
@section('title','Panel')
@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Canceled</h1>
      <a href="{{route('admin.datapanel')}}" style="position: absolute; right:15px;" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-folder-open"></i> Data Panel</a>
  </div>
<div  class="col-md-12" id="message"></div>
<div class="card shadow pt-3 mb-4 col-md-12">
    <div class="card-body">
      <div class="message d-none"></div>
        <div style="max-width:100%;" class="table-responsive">
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
        ajax: '{!! route('admin.ajax.cancel') !!}',
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

    });
</script>
<script type="text/javascript">
  $(function(){
      $('#datatable').on('click', '.recoverBtn', function(){
          var id = $(this).attr('id');
          $.get("{{route('admin.recover')}}", {id:id}, function(data){
            $('#datatable').DataTable().ajax.reload();
            $("#message").html('<div class="alert alert-info col-md-3">Data recovered.</div>').show().delay(1500).fadeOut('slow');
          });
      });
  })
</script>
<script type="text/javascript">
  $(function(){
      $('#datatable').on('click', '.destroyBtn', function(){
        if (confirm("Are you sure you want to delete the data completely?")==true) {
          var id = $(this).attr('id');
          $.get("{{route('admin.destroy')}}", {id:id}, function(data){
            $('#datatable').DataTable().ajax.reload();
            $("#message").html('<div class="alert alert-success col-md-3">Deleted successfully.</div>').show().delay(1500).fadeOut('slow');
          });
        }
        return false;
      });
  })
</script>
@endsection
