@extends('layouts.app')

@section('content')
<body>
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary card-1">

                <div class="panel-heading">
                    <div class='textmetalic'><center><span>S</span>&nbsp;<span>I</span>&nbsp;<span>M</span>&nbsp;<span>P</span>&nbsp;<span>L</span>&nbsp;<span>E</span><span> </span>&nbsp;</center></div>
                    <div><center><b>Take SIMPLE To Next Level</b></center></div>  
                <br>
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label"><i class="fa fa-user" aria-hidden="true"></i> User Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif 
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label"><i class="fa fa-key" aria-hidden="true"></i> Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-sign-in" aria-hidden="true"></i> Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
