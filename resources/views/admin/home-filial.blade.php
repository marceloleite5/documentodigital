@extends('layouts.base')

@section('content')

<div class="conteudo">
    <div class="home">
        <div class="lado-esquerdo">
            <h1><b>Filiais</b></h1>
            <div class="tabela">
                <table class="table table-striped table-condensed table-hover">
                    <thead>
                      
                    </thead>
                    <tbody>
                        @foreach($filiais as $filial)
                        <tr>
                            <td><a href="{{route('home.filial', $filial->id)}}">{{$filial->nome}}</a><td>
                        </tr>
                        @endforeach               
                    </tbody>
                  </table>
            </div>
        </div>
        <div class="meio">
            <h1><b>Documentos: {{ $qtd_doc}}</b></h1>
        </div>
        <div class="lado-direito">
            <h1><b>Imagens: {{$qtd_img}}</b></h1>
        </div>
        <div class="graf1">
            <h1><b>Quantitativo de Documentos por Filial: {{$filial_nome}}</b></h1>
            <script type="text/javascript">
            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawMultSeries);

            function drawMultSeries() {
                var data = google.visualization.arrayToDataTable([
                    ['Setor', 'Qtd Documentos', 'Qtd Imagens'],
                    @foreach ($graficos as $graf)
                        ["{{ $graf->nome }}", {{ $graf->qtd_doc }}, {{ $graf->qtd_img }}],
                    @endforeach
                ]);

                var options = {
                    title: '',
                    chartArea: {width: '50%'},
                    hAxis: {
                    title: 'Quantidade',
                    minValue: 0
                    },
                    vAxis: {
                    title: 'Setores'
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById('grafico'));
                chart.draw(data, options);
                }
                </script>
                <div id="grafico"></div>
        </div>
    </div>
</div>
@endsection