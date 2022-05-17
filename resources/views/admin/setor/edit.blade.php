@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Setores</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('setores.index') }}" style="color: #FFF;">
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
    <form class="form-horizontal" method="post" action="{{ route('setores.update', $setor->id) }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="form1">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Setor:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $setor->nome }}">
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
