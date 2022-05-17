@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Lista de Grupos</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('grupos.create') }}" style="color: #FFF;">
            <i style="font-size: 20px;" class="glyphicon glyphicon-plus" aria-hidden="true"></i> Cadastrar
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

    <form id="Form" name="Form">
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Grupo de Usuários</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($grupos as $grupo)
        <tr>
            <td>{{$grupo->nome}}</td>
            <td width="100">
                <a href="{{route('grupos.edit', $grupo->id)}}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>

                <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="{{ $grupo->id }}">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>
        </tr>
        @endforeach
    </table>
    </form>

</div>

<!-- Modal -->
<form id="deleteForm" method="get" action="{{ route('grupos.destroy') }}">
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
            <input type="hidden" name="grupo_id" id="grupo_id" value="">
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
    modal.find('#grupo_id').val(recipientId);
})
</script>
@endsection
