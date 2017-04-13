@if (count($errors)>0)
         <div class="row">
            <div class="col-md-6 col-md-offset-6 error text-center">
              <ul>
                 @foreach ($errors->all() as $error)
                   <li>{{$error}}</li>
                 @endforeach
              </ul>
            </div>
         </div>
@endif

@if (Session::has('message'))
         <div class="row">
            <div class="col-md-6 col-md-offset-6 success text-center">
              {{ Session::get('message')}}    
            </div>
         </div>
    @endif