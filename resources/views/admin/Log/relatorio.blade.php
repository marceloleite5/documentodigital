@extends('layouts.baserel')

@section('content')

<div class="corpo">
    <div class="toporel">
        <h2 class="text-center">Sistema Documento Digital<h2>
        <h3 class="text-center">Relatório de Logs<h3>
    </div>
    <table class="table table-striped table-condensed table-hover">
        <tr>
            <th>USUÁRIO</th>
            <th>DATA</th>
            <th>OPERAÇÃO</th>
            <th>TIPO</th>
            <th>OBJETO</th>
        </tr>
        @foreach($logs as $log)
        <tr>
            <td>{{ $log->user->name }}</td>
            <td>{{ \Carbon\Carbon::parse($log->data)->format('d/m/Y') }}</td>
            <td>{{ $log->operacao->nome }}</td>
            <td>{{$log->tipobj}}</td> 
            <td>{{$log->objeto}}</td> 
        </tr>
        @if ($log->linha == 17)
            <tr>
                <th>USUÁRIO</th>
                <th>DATA</th>
                <th>OPERAÇÃO</th>
                <th>TIPO</th>
                <th>OBJETO</th>
            </tr>
        @endif
        @endforeach
    </table>
</div>

@endsection