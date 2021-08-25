function refresh(){
    window.location.reload();
}

function voltar() {
    window.history.go(-1)
}

$(document).ready(function(){
    $.get('requestAjax', function(data){
        console.log(data);
    })
})

