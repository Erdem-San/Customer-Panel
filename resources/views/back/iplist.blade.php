  @extends('back.layouts.master')
  @section('title','Panel')
  @section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Ip List</h1>
  </div>
  <div  class="col-md-12" id="message"></div>
  <div class="card shadow mb-4 pt-3 col-md-12">
    <div class="card-body">
      <div style="margin-left:-20px;" class="col-12 mb-4">
        <form class="form-group col-5" id="myForm" action="{{route('admin.iplist.insert')}}" method="POST">
          @csrf
          <input class="form-control mb-2" type="text" id="myInput" name="ip">
          <button class="btn btn-primary btn-block" type="submit" id="myButton" name="button">Add</button>
        </form>
      </div>
      <div class="row overflow-auto"  style="max-height: 600px;">
          <div class="col-5">
            <div class="list-group" id="myTab" role="tablist">
              @foreach ($iplists as $iplist)
                  <a class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <p>{{$iplist->ip}}</p>
                  </div>
                  </a>
                  <form style="position:relative;" class="d-flex justify-content-end" action="{{route('admin.iplist.delete')}}" method="get">
                    <input class="form-control" type="hidden" name="hideInput" value="{{$iplist->id}}">
                    <button style="margin: -50px 10px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" type="submit"><i class="fa fa-trash-alt"></i></button>
                  </form>
                  <form style="position:relative;" class="d-flex justify-content-end" action="{{route('admin.iplist.update')}}" method="post">
                    @csrf
                    <input class="form-control" type="hidden" name="hideInput" value="{{$iplist->id}}">
                    <input required style="display: none; border-color:purple;" type="text" name="ip" class="form-control editInput">
                    <button class="btn btn-secondary closeButton" style="display: none;margin: -50px 60px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;"  type="button"><i class="fa fa-times"></i></button>
                    <button style="margin: -50px 60px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-primary editButton" type="button"><i class="fa fa-edit"></i></button>
                    <button style="display: none;border-color: purple;background-color: purple;margin: -50px 105px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-primary realEditButton" type="submit">Update</button>
                  </form>
              @endforeach
            </div>
          </div>
          <div class="col-md-1">
              <ul class="list-group">
                @foreach ($iplists as $iplist)
                  <li style="padding-top:20px;padding-bottom:21px;"
                    class="list-group-item text-center"><div class="ipSelect"> <i data="{{$iplist->status}}" data-status="@if($iplist->status==0) false @else true @endif" id="{{$iplist->id}}" class="fa fa-circle @if($iplist->status==0) text-danger @else text-success @endif "></i></div>
                  </li>
                @endforeach
              </ul>
          </div>
        </div>
    </div>
  </div>
  @endsection
  @section('css')
    <style media="screen">
      .active.list-group-item{
         background-color: #fdb827!important;
         border-color: #fdb827!important;
         color:#5a5c69;
      }
      .ipSelect i{
        cursor: pointer;
        font-size: 20px;
      }

    </style>
  @endsection
  @section('js')
    <script type="text/javascript">
      var triggerTabList = [].slice.call(document.querySelectorAll('#myTab a'))
      triggerTabList.forEach(function (triggerEl) {
        var tabTrigger = new bootstrap.Tab(triggerEl)

        triggerEl.addEventListener('click', function (event) {
          event.preventDefault()
          tabTrigger.show()
        })
      })
    </script>
    <script type="text/javascript">
      $(function(){
        $('.editButton').on('click',function(){
          var parentForm=$(this).parent('form');
          parentForm.find('.realEditButton').show();
          $(this).hide();
          parentForm.find('.editInput').show();
          parentForm.find('.closeButton').show();
          $('.closeButton').click(function(){
            $(this).parent('form').find('.realEditButton').hide();
            $(this).parent('form').find('.editInput').hide();
            $(this).parent('form').find('.editButton').show();
            $(this).hide();
          });
        });
      });
    </script>
    <script type="text/javascript">
      $('.ipSelect i').on('click', function(){
        var id=$(this).attr('id');
        var status=$(this).attr('data');
        var statu=$(this).attr('data-status');
        if (status==1) {
          $(this).removeClass('text-success').addClass('text-danger');
          $(this).attr('data', '0');
          $.get("{{route('admin.iplist.switch')}}", {id:id,statu:statu}, function(data, status){
          });
        } else {
          $(this).removeClass('text-danger').addClass('text-success');
          $(this).attr('data', '1');
          $.get("{{route('admin.iplist.switch')}}", {id:id,statu:statu}, function(data, status){
          });
        }
      });
    </script>
  @endsection
