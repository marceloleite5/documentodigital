<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html lang='pt_BR'>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sistema Documento Digital</title>
</head>
<body>
    @if ($imagem->tipo == "jpg")
        <img src="{{ url('imagens/' . $imagem->endereco) }}">
    @else
    <p>
        <iframe src="{{ url('imagens/' . $imagem->endereco) }}" style="width: 800px; height: 900px;"></iframe>
    </p>
    @endif
</body>
<html>