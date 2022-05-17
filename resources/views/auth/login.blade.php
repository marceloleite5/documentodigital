<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang='pt_BR'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Documento Digital</title>
<link rel="shortcut icon" href="{{ URL::asset('img/favicon.png') }}" type="image/x-icon" />
<link rel="stylesheet" href="{{ URL::asset('css/style_login.css') }}">
</head>
<body>
<form method="POST" action="{{ route('login') }}">
@csrf
<div class="login-box">
  <h1>Documento Digital</h1>
  <div class="textbox">
    <i class="fas fa-user"></i>
    <input placeholder="E-Mail" type="email" name="email" :value="old('email')" required autofocus />
  </div>
    @if ($errors->has('email'))
    <span class="help-block">
        <strong>{{ $errors->first('email') }}</strong>
    </span>
    @endif
  <div class="textbox">
    <i class="fas fa-lock"></i>
    <input placeholder="Senha" type="password" name="password" required autocomplete="current-password" />
  </div>
  @if ($errors->has('password'))
  <span class="help-block">
      <strong>{{ $errors->first('password') }}</strong>
  </span>
  @endif

  <input type="submit" class="btn" value="Entrar">
</div>
</form>
</body>
</html>