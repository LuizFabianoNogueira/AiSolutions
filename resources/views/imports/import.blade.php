<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Teste PHP</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>
<body style="background-color: #282525;">

<div class="row">
    <div class="col-12 text-center">
        <span style="color: #FFFFFF; font-size: 24px; padding-left: 20px; padding-top: 15px;">
            Luiz Fabiano Nogueira - Exemplo de importação
        </span>
    </div>
</div>

<div class="row" style="margin-top: 30px; padding: 50px;">
    <div class="col-6" style="color: #f7fafc; padding: 30px;">
        <div style="border: dashed 1px #718096; padding: 20px;">
            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Solução com JQuery</h2>

            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Nesta solução o jQuery lê o arquivo json exibe os dados na tela e envia individualmente os dados no formato assíncrono.
            </p>
            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Selecionae o Arquivo<br />
                <input type="file" id="jsonFileInput">
            </p>
            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
            <pre id="jsonDataDisplay"></pre>
            </p>
        </div>
    </div>

    <div class="col-6" style="color: #f7fafc; padding: 30px;">
        <div style="border: dashed 1px #718096; padding: 20px;">
            <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Solução com PHP</h2>
            <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                Nesta solução enviamos os dados para que o php possa ler e gerar uma fila de processamento.
            </p>
            <form method="POST" action="{{ route('addDocumentJob') }}" name="form" id="form" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    Selecionae o Arquivo<br />
                    <input type="file" id="jsonFileInputPHP" name="jsonFile">
                </p>
                <button type="submit" class="btn btn-outline-success">Enviar</button>
            </form>
        </div>
    </div>

</div>

</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script>

    $(document).ready(function() {
        $('#jsonFileInput').change(function(e) {
            $('#jsonDataDisplay').html('');
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onload = function(e) {
                let jsonData = JSON.parse(e.target.result);
                $.each( jsonData.documentos, function( key, value ) {
                    let category = value.categoria;
                    let title = value.titulo;
                    let contents = value.conteúdo;

                    let html = '<div id="box_'+key+'" class="card mb-2 box-jquery-data" style="color: #718096;" data-key="'+key+'" data-title="'+title+'" data-category="'+category+'" data-contents="'+contents+'">'+
                                    '<div class="card-header">'+
                                        title +
                                    '</div>'+
                                    '<div class="card-body">'+
                                        '<h5 class="card-title">'+category+'</h5>'+
                                        '<p class="card-text">'+contents+'</p>'+
                                    '</div>'+
                                '</div>';

                    $('#jsonDataDisplay').append(html);

                });
                let btn = '<button onclick="sendDataJs()" type="button" class="btn btn-outline-success">Enviar</button>'
                $('#jsonDataDisplay').append(btn);
            };
            reader.readAsText(file);
        });
    });

    function sendDataPHP()
    {
        $.post("{{ route('addDocumentJob') }}",
            $("#form").serialize()
        , function(data, status, xhr) {
            if(data.status === 'OK'){
                $(obj).fadeOut();
            }
        });
    }

    function sendDataJs()
    {
        let loading = '<div class="p-3"><div class="spinner-border text-info" role="status"><span class="sr-only"></span></div> Aguarde...</div>';

        $(".box-jquery-data").each(function( index ) {
            let obj = this;
            $(obj).html(loading);

            let key = $(obj).data('key');
            let title = $(obj).data('title');
            let category =  $(obj).data('category');
            let contents = $(obj).data('contents');

            $.post("{{ route('addDocument') }}", {
                '_token': '{{ csrf_token() }}',
                key:key,
                title:title,
                category :category,
                contents : contents
            }, function(data, status, xhr) {
                if(data.status === 'OK'){
                    $(obj).fadeOut();
                }
            });

        });
    }
</script>
