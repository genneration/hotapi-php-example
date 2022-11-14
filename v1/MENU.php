<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}
input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}
input[type=button] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width:90%;
}
input[type=button]:hover {
  background-color: #45a049;
}
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  margin-bottom:20px;
  text-align:center;
}
.fname{ text-align:center; padding:10px 0 10px 0; }
h3{ text-align:center; }
</style>

<hr style="margin-top:50px;">
<h3>DADOS DE AUTENTICAÇÃO (não podem estar públicos aqui só exemplo)</h3>
<?php
//INCLUDES DE CONTROLE --->>>
include "inc/globalVars.php";//vars padrao
//INCLUDES DE CONTROLE ---<<<

//imprimir dados de de requisição GET a API...............................................................................
echo "<br><br><b>URL GET API:</b> (não digulgue esses dados)<br>";
echo VAR_INSTANCE_URL;

echo "<br><br><b>fLogin:</b> (não digulgue esses dados)<br>";
echo VAR_INSTANCE_LOGIN;

?>

<hr style="margin-top:150px;">
<h3>MÉTODOS DA INSTÂNCIA (/instance)</h3>
<div class="container">
    <div class="fname">Método de verificação de conexão ou retorno de código QR para conexão</div>
    <input type="button" value="CONNECT" onClick="window.location='instance.connect.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Método de verificação de retorno do status atual da instância</div>
    <input type="button" value="STATE" onClick="window.location='instance.state.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Método que força a desconexão</div>
    <input type="button" value="DISCONNECT" onClick="window.location='instance.disconnect.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Método permite alteração do URL do webhook de retorno</div>
    <input type="button" value="WEBHOOK" onClick="window.location='instance.webhook.php';">
  </form>
</div>





<hr style="margin-top:150px;">
<h3>MÉTODOS DA MENSAGEM (/message)</h3>
<div class="container">
    <div class="fname">Enviar mensagem de texto simples</div>
    <input type="button" value="TEXT" onClick="window.location='message.text.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar mensagem com botões</div>
    <input type="button" value="BUTTONS" onClick="window.location='message.buttons.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar mensagem com lista de opções</div>
    <input type="button" value="OPTIONS" onClick="window.location='message.options.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar localização</div>
    <input type="button" value="LOCATION" onClick="window.location='message.location.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar Imagem</div>
    <input type="button" value="IMAGE" onClick="window.location='message.image.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar Vídeo</div>
    <input type="button" value="VIDEO" onClick="window.location='message.video.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar Áudio</div>
    <input type="button" value="AUDIO" onClick="window.location='message.audio.php';">
  </form>
</div>
<div class="container">
    <div class="fname">Enviar Documento</div>
    <input type="button" value="DOCUMENT" onClick="window.location='message.document.php';">
  </form>
</div>











