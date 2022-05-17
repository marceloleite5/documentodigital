@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Mudança de Senha</h2>  
    </div>

    <form class="form-horizontal" method="post" action="{{ route('usuario.password.update') }}">

        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form2">
            
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password_anterior">Senha Anterior:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_anterior">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password">Senha Nova:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password_confirmation">Confirme:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_confirmation">
              </div>
            </div>
            
            <div class="form-central" style="margin-top: 45px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>
            @if ( isset($errors) && count($errors) > 0) 
                <div class="alert alert-warning">
                    @foreach ($errors->all() as $error)
                        <p>{{$error}}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('success'))
                <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
                {{Session::get('success')}}    
                </div>  
            @endif
        </div>
    </form>
</div>
@endsection