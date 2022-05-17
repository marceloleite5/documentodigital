@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Administração de Permissões de Acesso</h2>
    </div>

    <div class="form-central" style="margin-top: 0px;">
        <div class="btn btn-primary" style="margin-bottom: 10px; margin-left: 10px;">
            <a href="{{ route('grupos.index') }}" style="color: #FFF;">
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
    <form class="form-horizontal" method="post" action="{{ route('permissoes.store', $grupo->id) }}">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <div class="aba">
            <ul class="nav nav-tabs">
                <li><a href="{{route('grupos.edit', $grupo->id)}}">Grupo</a></li>
                <li class="active"><a href="{{route('permissoes.index', $grupo->id)}}">Permissões de Acesso</a></li>
            </ul>
        </div>
        <div class="form1">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="nome">Grupo:</label>
              <div class="col-sm-8">
                  <input class="form-control" type="text" name="nome" value="{{ $grupo->nome }}">
              </div>
            </div>

        </div>

        <div class="form2">
            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="form_id">Formulário:</label>
              <div class="col-sm-8">
                    <select class="form-control" name="form_id">
                        <option value="">Selecione</option>
                        @foreach($forms as $form)
                            <option value="{{$form->id}}">{{$form->nome}}</option>
                        @endforeach
                    </select>
              </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="inclui">Permissoes:</label>
                <div class="col-sm-2">
                    <input type="checkbox" name="inclui"> Inclui
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="altera"></label>
                <div class="col-sm-2">
                    <input type="checkbox" name="altera"> Altera
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="control-label col-sm-2" for="exclui"></label>
                <div class="col-sm-2">
                    <input type="checkbox" name="exclui"> Exclui
                </div>
            </div>

            <div class="form-central" style="margin-top: 20px;">
                <div class="form-group">
                  <button type="submit" class="btn btn-primary">
                    <i style="font-size: 20px;" class="glyphicon glyphicon-floppy-disk" aria-hidden="true"></i> Salvar
                  </button>
                </div>
            </div>

        </div>
    </form>

    <br><br><br>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>Formulário</th>
            <th>INCLUI</th>
            <th>ALTERA</th>
            <th>EXCLUI</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($permissoes as $permissao)
        <tr>
            <td>{{ $permissao->nome }}</td>
            @if($permissao->inclui==1)
                <td>
                    <input type="checkbox" checked id="inc">
                </td>
            @else
                <td>
                    <input type="checkbox" id="inc">
                </td>
            @endif
            @if($permissao->altera==1)
                <td>
                    <input type="checkbox" checked id="alt">
                </td>
            @else
                <td>
                    <input type="checkbox" id="alt">
                </td>
            @endif
            @if($permissao->exclui==1)
                <td>
                    <input type="checkbox" checked id="exc">
                </td>
            @else
                <td>
                    <input type="checkbox" id="exc">
                </td>
            @endif
            <td width="100">

                <a href="{{route('permissoes.edit', $permissao->id)}}" class="btn btn-primary btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>


                <a href="{{route('permissoes.destroy', $permissao->id)}}" class="btn btn-danger btn-sm" style="color: #FFF; margin-right: 5px;">
                    <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
                </a>

            </td>

        </tr>

        @endforeach

    </table>
</div>
@endsection
