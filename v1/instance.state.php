<?php // Albert Faisher - faisher@gmail.com - 01-11-2022
//INCLUDES DE CONTROLE --->>>
include "inc/globalVars.php";//vars padrao
//INCLUDES DE CONTROLE ---<<<

?>
<div style="padding:20px;"><input style="background-color: #F60; font-size:18px; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width:90%;" name="Voltar" type="button" value="Voltar ao MENU" onclick="window.location='MENU.php';" /></div>


<?



//ENVIA POS PARA API........................................................................................
$url_auth_api = VAR_INSTANCE_URL."/instance";//URL DE POST PARA API E METODOS SELECIONADOS
$postParameter = array(//VARIÁVEIS POST DA REQUISICAO
    //"DEBUG"=>1,//se definir ele retorna uma variavel debug com as variaveis POST recebidas no servidor
    "fLogin"=>VAR_INSTANCE_LOGIN,
    "ACTION"=>"STATE",
);
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
echo "<br><br><br><b>DADOS DE RESPOSTA DA REQUISIÇÃO:</b><pre>"; print_r($arrayResponse); echo "</pre>";














//VERIFICA SE O RETORNO FOI BEM SUCEDIDO E MONTA AS VERIFICAÇÕES.................................................................
if($arrayResponse["isValid"] == "true"){
	echo "<br><br><br>*********************************************************************************************************";
	echo "<br><br><b>AÇÕES SIMULADAS:</b> (verifica retorno da verificação de status da conexão)";
	echo "<br> - ID INSTÂNCIA: <b>".$arrayResponse["instance_id"]."</b>";	


	//VERIFICA SE ESTÁ INATIVO, NÃO ESTÁ OPERANTE--------------------------------------------------------------------------------
	if($arrayResponse["result"]["state"] == "inactive"){
		echo "<br> - STATUS: <b>INATIVO - SEM USO POSSÍVEL</b>";
	}

	//VERIFICA SE ESTÁ AGUARDANDO O SERVIDOR MONTAR A INSTÂNCIA E LIBERAR O USO--------------------------------------------------
	if($arrayResponse["result"]["state"] == "activaction"){
		echo "<br> - STATUS: <b>EM ATIVAÇÃO - AGUARDANDO SERVIDOR LIBERAR</b>";	
	}

	//VERIFICA SE ESTÁ AGUARDANDO CONEXÕES PARA ENVIO DE MENSAGENS---------------------------------------------------------------
	if($arrayResponse["result"]["state"] == "disconnected"){
		echo "<br> - STATUS: <b>DESCONECTADO - AGUARDANDO PAREMENTO COM APP</b>";	
	}

	//VERIFICA SE ESTÁ CONECTADO E PRONTO PRA ENVIO DE MENSAGENS-----------------------------------------------------------------
	if($arrayResponse["result"]["state"] == "connected"){
		echo "<br> - STATUS: <b>CONECTADO - ENVIANDO E RECEBENDO MENSAGENS</b>";		
		echo "<br> - NÚMERO: <b>".$arrayResponse["result"]["number"]."</b>";
		echo "<br> - NOME: <b>".$arrayResponse["result"]["name"]."</b>";	
	}

}//if($arrayResponse["isValid"] == "true"){
?>
    <div style="padding:20px;"><input style="font-size:24px;" name="Atualizar" type="button" value="Atualizar" onclick="window.location='?';" /></div>
<?php

