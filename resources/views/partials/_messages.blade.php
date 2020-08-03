@if(Session::has('alert-message'))
    <div class="alert {{ Session::get('alert-message')['alert-class'] }} {{ Session::get('alert-message')['alert-type'] }} alert-dismissible fade show rounded-0 border-0" role="alert">
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::pull('alert-message')['message'] }}</strong>
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger rounded-0 border-0 bg-danger text-white">
        <button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <ul class="m-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
