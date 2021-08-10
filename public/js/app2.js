function rolagem(){
    var objDiv = document.getElementById("#scroll");
    objDiv.scrollTop = objDiv.scrollHeight;
}

function refresh(){
    window.location.reload();
}

function voltar() {
    window.history.go(-1)
}

