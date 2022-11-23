<?php // Albert Faisher - faisher@gmail.com - 01-11-2022
//INCLUDES DE CONTROLE --->>>
include "inc/globalVars.php";//vars padrao
//INCLUDES DE CONTROLE ---<<<



//FORMULÁRIO PARA INTERAÇÃOM COM A API.........................................................................................................
?>
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
input[type=submit] {
  background-color: #04AA6D;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
input[type=submit]:hover {
  background-color: #45a049;
}
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
  margin-bottom:50px;
}
</style>
<h3>FORMULÁRIO DE ENVIO DE MENSAGEM COM BOTÕES</h3>

<div class="container">
  <form action="?#ancoraResp" method="POST">  
    <label for="fname">Número ( [CÓDIGO DO PAÍS]+[DDD]+[NÚMERO] )</label>
    <input type="text" id="destination" name="destination" value="" placeholder="Informe o número">
    
    <label for="subject">Texto da mensagem</label>
    <textarea id="text" name="text" placeholder="Definir a mensagem de texto.." style="height:200px"></textarea>
    
    <hr />
    <label for="fname">Botão 1</label>
    <input type="text" id="botao1" name="botao1" value="BOTÃO 1" placeholder="Legenda do botão">
    
    <label for="fname">Botão 2</label>
    <input type="text" id="botao2" name="botao2" value="BOTÃO 2" placeholder="Legenda do botão">
    
    <label for="fname">Botão 3</label>
    <input type="text" id="botao3" name="botao3" value="BOTÃO 3" placeholder="Legenda do botão">
    
    <label for="fname">Botão 4</label>
    <input type="text" id="botao4" name="botao4" value="BOTÃO 4" placeholder="Legenda do botão">
    
    <input type="submit" value="ENVIAR">
  </form>
</div>

<div style="padding:20px;"><input style="background-color: #F60; font-size:18px; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width:90%;" name="Voltar" type="button" value="Voltar ao MENU" onclick="window.location='MENU.php';" /></div>
<?php
































//POST PARA ENVIO DOS DADOS.................................................................................................................................................
if(isset($_POST["destination"])){









//ENVIA POS PARA API........................................................................................
$url_auth_api = VAR_INSTANCE_URL."/message";//URL DE POST PARA API E METODOS SELECIONADOS
$postParameter = array(//VARIÁVEIS POST DA REQUISICAO
    //"DEBUG"=>1,//se definir ele retorna uma variavel debug com as variaveis POST recebidas no servidor
    "fLogin"=>VAR_INSTANCE_LOGIN,
    "ACTION"=>"BUTTONS",
	"destination"=>$_POST["destination"],
	"text"=>$_POST["text"]
);


//ADICIONAR O ARRAY DE BOTÕES RECEBIDOS PARA ENVIO...........................................................
$ARRAY_BOTTONS = array();
if((isset($_POST["botao1"])) and ($_POST["botao1"] != "")){ $ARRAY_BOTTONS[] = array("id"=>"1","label"=>$_POST["botao1"]); }
if((isset($_POST["botao2"])) and ($_POST["botao2"] != "")){ $ARRAY_BOTTONS[] = array("id"=>"2","label"=>$_POST["botao2"]); }
if((isset($_POST["botao3"])) and ($_POST["botao3"] != "")){ $ARRAY_BOTTONS[] = array("id"=>"3","label"=>$_POST["botao3"]); }
if((isset($_POST["botao4"])) and ($_POST["botao4"] != "")){ $ARRAY_BOTTONS[] = array("id"=>"4","label"=>$_POST["botao4"]); }

//ADICIONAR ARRAY DE BOTÕES NO ARRAR POST DE ENVIO...........................................................
$postParameter["buttons"] = $ARRAY_BOTTONS;

//url-ify the data for the POST..............................................................................
$fields_string = http_build_query($postParameter);
//INFORMAÇÕES DO cURL PHP >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$curlHandle = curl_init($url_auth_api);
curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curlHandle, CURLOPT_HTTP_VERSION,CURL_HTTP_VERSION_1_1);
//curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST,'GET');
//curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
$curlResponse = curl_exec($curlHandle);
$httpcode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
curl_close($curlHandle);
//converter dados jSon de resposta da API para array PHP
$arrayResponse = json_decode($curlResponse,true);
//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<





//imprimir dados de de requisição GET a API...............................................................................
echo "<br><b>URL GET API:</b> (não digulgue esses dados)<br>";
echo $url_auth_api;



//imprimir dados de requisição POST a API..................................................................................
echo "<br><br><br><b>DADOS DE POST ENVIADOS:</b><pre>"; print_r($postParameter); echo "</pre>";




//imprimir status da requisição http da API........................................................................................
echo "<br><br><br><b>STATUS DA REQUISIÇÃO:</b><pre>"; print_r($httpcode); echo "</pre>";


//imprimir dados de resposta da API........................................................................................
echo "<br><br><br><b>DADOS DE RESPOSTA DA REQUISIÇÃO:</b><pre>"; print_r($curlResponse); echo "</pre>";














//VERIFICA SE O RETORNO FOI BEM SUCEDIDO E MONTA AS VERIFICAÇÕES.................................................................
if($arrayResponse["isValid"] == "true"){
	echo "<br><br><br>*********************************************************************************************************";
	echo "<br><br><b>AÇÕES SIMULADAS:</b> (verifica retorno da verificação de conexão)";
	echo "<br> - ID INSTÂNCIA: <b>".$arrayResponse["instance_id"]."</b>";	


	//VERIFICA SE ESTÁ INATIVO, NÃO ESTÁ OPERANTE--------------------------------------------------------------------------------
	if(isset($arrayResponse["result"]["message_id"])){
		echo "<br> - ID DE CONTROLE DA MENSAGEM DE FILA: <b>".$arrayResponse["result"]["message_id"]."</b>";
	}

}//if($arrayResponse["isValid"] == "true"){
?>
   <div style="padding:20px;" id="ancoraResp"><input style="font-size:24px;" name="Atualizar" type="button" value="Limpar" onclick="window.location='?';" /></div>
<?php




}//if(isset($_POST["destination"])){
//POST PARA ENVIO DOS DADOS.................................................................................................................................................






