@extends('back.layouts.master')
@section('title','Panel')
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Customer</h1>
</div>
<div  class="col-md-12" id="message"></div>
<div class="card shadow mb-4 pt-3 col-md-12">
  <div class="card-body">
    <div class="row">
        <div style="margin-left:-10px;" class="col-12 mb-4">
          <form class="form-group col-4" id="myForm" action="{{route('admin.customer.insert')}}" method="POST">
            @csrf
            <input class="form-control mb-2" type="text" id="myInput" name="name">
            <button class="btn btn-primary btn-block" type="submit" id="myButton" name="button">Add</button>
          </form>
        </div>
        <div class="col-4">
          <div class="list-group overflow-auto" id="myTab" style="max-height: 400px;" role="tablist">
            @foreach ($customers as $customer)

                <a class="list-group-item list-group-item-action"
                data-bs-toggle="list" href="#{{$customer->name}}" role="tab">
                <div class="d-flex w-100 justify-content-between">
                  <p>{{$customer->name}}</p>
                </div>
                </a>
                <form style="position:relative;" class="d-flex justify-content-end" action="{{route('admin.customer.delete')}}" method="get">
                  <input class="form-control" type="hidden" name="hideInput" value="{{$customer->id}}">
                  <button style="margin: -50px 10px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');" type="submit"><i class="fa fa-trash-alt"></i></button>
                </form>
                <form style="position:relative;" class="d-flex justify-content-end" action="{{route('admin.customer.nameupdate')}}" method="post">
                  @csrf
                  <input class="form-control" type="hidden" name="hideNameInput" value="{{$customer->id}}">
                  <input required style="display: none; border-color:purple;" type="text" name="name" class="form-control editInput">
                  <button class="btn btn-secondary closeButton" style="display: none;margin: -50px 60px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;"  type="button"><i class="fa fa-times"></i></button>
                  <button style="margin: -50px 60px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-primary editButton" type="button"><i class="fa fa-edit"></i></button>
                  <button style="display: none;border-color: purple;background-color: purple;margin: -50px 105px 0px 0px;padding-bottom: 6px;position: absolute;z-index:10;" class="btn btn-primary realEditButton" type="submit">Update</button>
                </form>
            @endforeach
          </div>
        </div>
        <div class="col-8">
          <div class="tab-content overflow-auto" style="max-height: 400px;" id="nav-tabContent">
            @foreach ($customers as $customer)
              <div class="tab-pane" id="{{$customer->name}}" role="tabpanel">
                  <div id="accordion">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                          <button class="btn btn-link" data-toggle="collapse" data-target="#collapse" aria-expanded="true" aria-controls="collapseOne">
                            IP List
                          </button>
                        </h5>
                      </div>

                      <div id="collapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                          @foreach($customer->getData as $data)
                            <li>{{$data->ip}}</li>
                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="mt-3">
                    <b>Comment</b>
                    <p>{{$customer->comment}}</p>
                  </div>
                  <button class="btn btn-primary mt-2 mb-2" type="button" data-toggle="collapse" data-target="#comment">
                    Add comment
                  </button>
                <div class="collapse" id="comment">
                  <form class="form-group" action="{{route('admin.customer.update')}}" method="post">
                    @csrf
                    <input type="hidden" name="hiddenId" value="{{$customer->id}}">
                    <textarea name="comment" class="form-control" rows="6" cols="80"></textarea>
                    <button type="submit" class="btn btn-success mt-2 btn-block" name="button">Send</button>
                  </form>
                </div>
                <div>
                <div class="d-flex align-self-end mt-2">
                  <b>Total Earnings:</b>
                  <h5>&nbsp;{{$customer->getData->sum('prix')}}$</h5>
                </div>

                </div>
              </div>
            @endforeach
          </div>
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

@endsection
