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
<h3>FORMULÁRIO DE ENVIO DE MENSAGEM COM IMAGEM</h3>

<div class="container">
  <form action="?#ancoraResp" method="POST" enctype="multipart/form-data">  
    <label for="fname">ID do grupo ( whats_id recebido na criação do grupo )</label>
    <input type="text" id="destination" name="destination" value="" placeholder="Informe o whats_id do grupo">
    
    <label for="subject">Texto de legenda</label>
    <textarea id="text" name="text" placeholder="Definir a mensagem de texto.." style="height:100px"></textarea>
    
    <hr>
    <label for="fname">ENVIAR ARQUIVO POR BASE64</label><br>
    <input type="file" name="image_upload" id="image_upload">
    
    <hr style="margin:30px 0;">
    <div>Escolher o de cima BASE64 OU o URL abaixo. (*Para o teste, preencha um ou o outro)</div>
    <hr style="margin:30px 0;">
    <label for="fname">ENVIAR POR UM URL PÚBLICO</label>
    <div>
    Nome: <input type="text" style="width:30%;" id="image_name" name="image_name" value="" placeholder="Opcional">
    - URL: <input type="text" style="width:50%;" id="image_url" name="image_url" value="https://images.all-free-download.com/images/graphiclarge/iphone_6_sample_photo_566464.jpg" placeholder="Enviar por uma URL">
    </div>
        
    <input type="submit" value="ENVIAR">
  </form>
</div>

<div style="padding:20px;"><input style="background-color: #F60; font-size:18px; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; width:90%;" name="Voltar" type="button" value="Voltar ao MENU" onclick="window.location='MENU.php';" /></div>
<?php
































//POST PARA ENVIO DOS DADOS.................................................................................................................................................
if(isset($_POST["destination"])){









//ENVIA POS PARA API........................................................................................
$url_auth_api = VAR_INSTANCE_URL."/group";//URL DE POST PARA API E METODOS SELECIONADOS
$postParameter = array(//VARIÁVEIS POST DA REQUISICAO
    //"DEBUG"=>1,//se definir ele retorna uma variavel debug com as variaveis POST recebidas no servidor
    "fLogin"=>VAR_INSTANCE_LOGIN,
    "ACTION"=>"IMAGE",
	"destination"=>$_POST["destination"],
	"text"=>$_POST["text"]
);






//ADICIONAR O ARRAY URL PARA ENVIO..............................................
if($_POST["image_url"] != ""){
	$postParameter["image_name"] = $_POST["image_name"];
	$postParameter["image_url"] = $_POST["image_url"];
	
}else{//if($_POST["image_url"] != ""){

	//ADICIONAR O ARRAY ARQUIVO PARA MONTAGEM DO MASE64 PARA ENVIO..............................................
	if(isset($_FILES['image_upload'])){
		$postParameter["image_name"] = $_FILES['image_upload']['name'];
		$file_bin = file_get_contents($_FILES['image_upload']['tmp_name']);
		//verificar tipo de arquivo
		$finfo = new finfo(FILEINFO_MIME_TYPE);
		$file_type = $finfo->buffer($file_bin);//pega informação MIME
		$postParameter["image_base64"] = "data:".$file_type.";base64,".base64_encode($file_bin);
	}//if(isset($_FILES['image_url'])){


}//else{//if($_POST["destination"] != ""){






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






