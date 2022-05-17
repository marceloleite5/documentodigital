@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Lista de Documentos</h2>
    </div>
    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('documentos.create') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-plus" aria-hidden="true"></i> Cadastrar
            </a>
        </div>
    </div>
    <form class="form-horizontal" method="get" action="{{ route('documentos.search') }}">
        <div class="form4">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-3" for="nome">Documento:</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" name="nome" value="{{ old('nome') }}">
                </div>
            </div>

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
                <label class="control-label col-sm-3" for="setor_id">Setor:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="setor_id">
                        <option value="">Selecione</option>
                        @foreach($setores as $setor)
                            <option value="{{$setor->id}}">{{$setor->nome}}</option>
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
                            <option value="{{$filial->id}}">{{$filial->nome}}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-central" style="margin-top: 35px;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-search" aria-hidden="true"></i> Pesquisar
                    </button>
                </div>
            </div>
        </div>
    </form>

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

    <br><br><br><br>
    <form id="Form" name="Form">
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Documento</th>
            <th>Data</th>
            <th>Setor</th>
            <th>Filial</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($documentos as $documento)
        <tr>
            <td>{{$documento->nome}}</td>
            <td>{{ \Carbon\Carbon::parse($documento->data_documento)->format('d/m/Y') }}</td>
            <td>{{$documento->setor->nome}}</td>
            <td>{{$documento->filial->nome}}</td>
            <td width="100">
                <a href="{{route('documentos.edit', $documento->id)}}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $documento->id }}">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>
        </tr>
        @endforeach
    </table>
    </form>
    @if( !isset($dataForm) )
        {!! $documentos->links() !!}
    @endif
</div>

<!-- Modal -->
<form id="deleteForm" method="get" action="{{ route('documentos.destroy') }}">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <p class="text-center">Confirma a exclusão do registro ?</p>
            </div>
            <input type="hidden" name="documento_id" id="documento_id" value="">
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-danger">Deletar</button>
            </div>
        </div>
        </div>
    </div>
</form>

<script type="text/javascript">
$('#deleteModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var recipientId    = button.data('id');
    console.log(recipientId);

    var modal = $(this);
    modal.find('#documento_id').val(recipientId);
})
</script>
@endsection
