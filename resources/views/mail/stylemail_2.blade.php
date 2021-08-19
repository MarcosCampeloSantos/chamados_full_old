<div style="text-align: center; margin-bottom: 1rem; margin-top: 1rem">
    <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif; font-style: bold">CHAMADOS</h1>
</div>
<div style="background-color: rgb(255, 255, 255); border-radius: 2rem; text-align: center; width: 75%;  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.288); padding: 1rem; margin-left: auto; margin-right: auto; font-size: 2rem">
    <div>
        <p style="font-family: Arial; font-size: 2.2rem ">Chamado <b>#{!!$chamado!!}</b> Criado Por: </p>
    </div>
    <div>
        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 2rem"><b>{{$usuario->name}}</b></p>
        <p style="font-family: Arial, Helvetica, sans-serif; font-size: 2rem"> Descrição: </p>
        <div style="font-family: Arial ;margin-left: auto; margin-right: auto; padding: 0.3rem ;word-break: break-all ;width: 75% ;border-radius: 1rem ;background-color:rgba(241, 241, 241, 0.863) ;box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.288) inset;">
            {!!$mensagem!!}
        </div>
        
    </div>
</div>
