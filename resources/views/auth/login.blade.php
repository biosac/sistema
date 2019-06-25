@extends('auth.contenido')

@section('login')
<div class="login-logo">
    <a href="#">Administración</a>
</div>
    <!-- /.login-logo -->
<div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <form class="was-validated" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group has-feedback {{ $errors->has('usuario' ? 'is-invalid' : '') }}">
        <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario"><span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group">{!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}</div>
        <div class="form-group has-feedback {{ $errors->has('passsword' ? 'is-invalid' : '') }}">
            <input type="password" name="password" id="password" class="form-control" placeholder="Password"><span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group">{!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}</div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label><input type="checkbox"> Remember Me</label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</div>
@endsection
