<nav class="navbar navbar-default">
    <div class="container-fluid">
  
      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="{{ url('/home') }}">Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tabelas <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/emails') }}">E-Mail</a></li>
                    <li><a href="{{ url('/setores') }}">Setor</a></li>
                    <li><a href="{{ url('/filiais') }}">Filial</a></li>
                    <li><a href="{{ url('/tipodocumentos') }}">Tipo de Documento</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Movimento <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/documentos') }}">Documento</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Relatórios <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/rel_log') }}">Relatório de Logs</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Segurança <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ url('/grupos') }}">Grupo de Usuários</a></li> 
                    <li><a href="{{ url('/usuarios') }}">Usuários</a></li>
                </ul>
            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name}} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ url('/usuario/password') }}">Mudança de Senha</a></li>
                <li role="separator" class="divider"></li>
                <li><a href="{{ url('usuario/logout') }}">Sair</a></li>
              </ul>
            </li>
          </ul>
      </div>
    </div>
</nav>