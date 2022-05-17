@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Usuários</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('usuarios.index') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-backward" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    @if ( isset($errors) && count($errors) > 0)
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
    <form class="form-horizontal" method="post" action="{{ route('usuarios.store') }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form3">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="name">Nome:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="name" value="{{ old('name') }}">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="email">E-Mail:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="email" name="email" value="">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password">Senha:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password" value="">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="password_confirmation">Confirme:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="password" name="password_confirmation">
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="grupo_id">Grupo Usuário:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="grupo_id">
                        <option value="">Selecione</option>
                        @foreach($grupos as $grupo)
                            <option value="{{$grupo->id}}">{{$grupo->nome}}</option>
                        @endforeach
                    </select>
              </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="status">Status:</label>
                <div class="col-sm-2">
                    <input type="radio" name="status" checked value="1"> Ativo
                </div>
                <div class="col-sm-2">
                    <input type="radio" name="status" value="0"> Inativo
                </div>
            </div>

            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection
