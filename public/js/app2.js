function refresh(){
    window.location.reload();
}

function voltar() {
    window.history.go(-1)
}

function teste(){
    $.get('requestAjax', function(data){
        var dados = JSON.stringify(data);

        $.ajax({
            url: '../resources/teste.php',
            type: 'POST',
            data: {data: dados},
            success: function(result){
              // Retorno se tudo ocorreu normalmente
              console.log(result);
            }
        });
    })
}

setInterval(teste, 1000);
