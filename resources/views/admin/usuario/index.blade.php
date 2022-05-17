@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="titulo">
        <h2>Lista de Usuários</h2> 
    </div>

    <div class="form-central" style="margin-top: 0px;">  
        <div class="btn btn-primary" style="margin-bottom: 10px;">
            <a href="{{ route('usuarios.create') }}" style="color: #FFF;">   
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
            <th>Usuário</th>
            <th>E-Mail</th>
            <th>Status</th>
            <th width="100">Ações</th>
        </tr>
        @foreach($usuarios as $usuario) 
        <tr>
            <td>{{$usuario->name}}</td>
            <td>{{$usuario->email}}</td>
            @if ($usuario->status == 1)
                <td>ATIVO</td>
            @else
                <td>INATIVO</td>
            @endif
            <td width="100">  
                <a href="{{route('usuarios.edit', $usuario->id)}}" class="btn btn-primary">
                    <i class="glyphicon glyphicon-edit" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </table>
    </form>
    
</div>

@endsection