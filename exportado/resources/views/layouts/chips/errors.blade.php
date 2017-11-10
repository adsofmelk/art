            
           @if(Session::has('error'))
           
           <div class='alert alert-danger alert-dismissible' role='alert'> 
                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                {{Session::get('error')}}
                
            </div>
            @endif
            
            @if(count($errors)>0)
           
           <div class='alert alert-danger alert-dismissible' role='alert'> 
                <button type='button' class='close' data-dismiss='alert' aria-label='close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
                <ul>
                    @foreach($errors->all() as $err)
                    <li>{!!$err!!}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            