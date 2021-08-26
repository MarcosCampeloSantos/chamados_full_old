function refresh(){
    window.location.reload();
}

function voltar() {
    window.history.go(-1)
}

function teste(){
    $.get('requestAjax', function(data){
        console.log(data);
    })
}

setInterval(teste, 1000);
