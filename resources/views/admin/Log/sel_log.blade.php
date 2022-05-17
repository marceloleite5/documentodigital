@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Relatório de Logs</h2> 
    </div>
    <form class="form-horizontal" method="get" target="_blank" action="{{ route('logs.relatorio') }}">   
        <div class="form6">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="data1">Período:</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data1" value="{{ old('data1') }}">
              </div>
              <label class="control-label col-sm-1" for="data2">A</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data2" value="{{ old('data2') }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="user_id">Usuário:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="user_id">
                        <option value="">Selecione</option>
                        @foreach($usuarios as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-print" aria-hidden="true"></i> Relatório
                    </button>
                </div>
            </div>
        </div>
    </form>

    @if ( isset($errors) && count($errors) > 0) 
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
    
</div>


@endsection