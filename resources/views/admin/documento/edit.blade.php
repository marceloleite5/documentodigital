@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Documentos</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('documentos.index') }}" style="color: #FFF;">
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
    <form class="form-horizontal" method="post" action="{{ route('documentos.update', $documento->id) }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="aba">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#">Documento</a></li>
                <li><a href="{{route('imagens.index', $documento->id)}}">Imagens do Documento</a></li>
            </ul>
        </div>
        <div class="form5">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="nome">Documento:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $documento->nome }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="data_documento">Data:</label>
              <div class="col-sm-3">
                  <input class="form-control" type="date" name="data_documento" value="{{ $documento->data_documento }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="tipodocumento_id">Tipo Documento:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="tipodocumento_id">
                        <option value="">Selecione</option>
                        @foreach($tipodocumentos as $tipodocumento)
                        @if ($tipodocumento->id == $documento->tipodocumento_id)
                            <option value="{{$tipodocumento->id}}" selected>{{$tipodocumento->nome}}</option>
                        @else
                            <option value="{{$tipodocumento->id}}">{{$tipodocumento->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="setor_id">Setor:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="setor_id">
                        <option value="">Selecione</option>
                        @foreach($setores as $setor)
                        @if ($setor->id == $documento->setor_id)
                            <option value="{{$setor->id}}" selected>{{$setor->nome}}</option>
                        @else
                            <option value="{{$setor->id}}">{{$setor->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="filial_id">Filial:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="filial_id">
                        <option value="">Selecione</option>
                        @foreach($filiais as $filial)
                        @if ($filial->id == $documento->filial_id)
                            <option value="{{$filial->id}}" selected>{{$filial->nome}}</option>
                        @else
                            <option value="{{$filial->id}}">{{$filial->nome}}</option>
                        @endif
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="armario">Armário:</label>
              <div class="col-sm-2">
                  <input class="form-control" type="text" name="armario" value="{{$documento->armario }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="gaveta">Gaveta:</label>
              <div class="col-sm-2">
                  <input class="form-control" type="text" name="gaveta" value="{{ $documento->gaveta }}">
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="pasta">Pasta:</label>
              <div class="col-sm-2">
                  <input class="form-control" type="text" name="pasta" value="{{ $documento->pasta }}">
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
