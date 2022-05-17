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
    @if(Session::has('success'))
        <div class="alert alert-success hide-msg" style="float:left; width:100%; margin:10px 0px;">
        {{Session::get('success')}}    
        </div>  
    @endif
    @if ( isset($errors) && count($errors) > 0) 
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
            <p>{{$error}}</p>
        @endforeach
    </div>
    @endif
    <form class="form-horizontal" method="post" action="{{ route('imagens.store', $documento->id) }}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="aba">
            <ul class="nav nav-tabs">
                <li><a href="{{route('documentos.edit', $documento->id)}}">Documento</a></li>
                <li class="active"><a href="{{route('imagens.index', $documento->id)}}">Imagens do Documento</a></li> 
            </ul>
        </div>
        <div class="form6">
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
        </div>

        <div class="form1">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="imagem">Imagem:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="file" name="imagem">
              </div>
            </div>

            @can('documentos', 'altera')
            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>
            @endcan
        </div>
    </form>
    <br><br><br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Imagem</th>
            <th width="150">Ações</th>
        </tr>
        @foreach($imagens as $imagem) 
        <tr>
            <td>{{ $imagem->endereco }}</td>
            <td width="150">
                <a href="{{route('imagens.print', $imagem->id)}}" target="_blank" class="btn btn-success btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-print" aria-hidden="true"></i>
                </a>
                <a href="{{route('imagens.send', $imagem->id)}}" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#sendModal" data-id="{{ $imagem->id }}" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-send" aria-hidden="true"></i>
                </a>
                @can('documentos', 'exclui')
                <a href="{{route('imagens.destroy', $imagem->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>
                @endcan
            </td>
        </tr>
        @endforeach 
    </table>
</div>

<!-- Modal -->
<form id="sendForm" method="get" action="{{ route('imagens.send') }}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">Enviar Imagem por E-Mail</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" style="text-align: right" for="email_id">E_Mail:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="email_id">
                        <option value="">Selecione</option>
                        @foreach($emails as $email)
                            <option value="{{$email->id}}">{{$email->email}}</option>
                        @endforeach
                    </select>
              </div>
            </div>
            <br>
            <div class="modal-body">
                <p class="text-center"></p>
            </div>
            <input type="hidden" name="imagem_id" id="imagem_id" value="">
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Enviar</button>
            </div>
        </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    $('#sendModal').on('show.bs.modal', function (event) {                                                       
        var button = $(event.relatedTarget); // Button that triggered the modal
        var recipientId    = button.data('id');
        console.log(recipientId);
        
        var modal = $(this);
        modal.find('#imagem_id').val(recipientId);
    })
    </script>
@endsection