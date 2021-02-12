<?php
include ("inc/common.php");
$str_conexao2= "host=db4.backup dbname=db4 port=5432 user=user password=password"; // CEP
if(!($db2=pg_connect($str_conexao2))) {
  echo "Não foi possível estabelecer uma conexão com o banco de dados";
  exit;
}
$Tirar = array("-",".");

$Cep = str_replace($Tirar, "", $_REQUEST['cep_entrega']);

$Sql = "SELECT LOG_LOGRADOURO.LOC_NU_SEQUENCIAL, LOG_LOGRADOURO.LOG_NOME AS LOGRADOURO, LOG_LOGRADOURO.CEP, LOG_LOGRADOURO.UFE_SG,
LOG_LOGRADOURO.LOG_NU_SEQUENCIAL, LOG_LOGRADOURO.LOG_STATUS_TIPO_LOG, LOG_BAIRRO.BAI_NO AS INICIAL, LOG_LOCALIDADE.LOC_NO,
(SELECT BAI_NO       FROM LOG_BAIRRO  WHERE BAI_NU_SEQUENCIAL = Log_Logradouro.BAI_NU_SEQUENCIAL_FIM) AS FINAL
FROM LOG_LOGRADOURO, LOG_BAIRRO, LOG_LOCALIDADE
WHERE (((LOG_LOGRADOURO.LOC_NU_SEQUENCIAL)=Log_bairro.LOC_NU_SEQUENCIAL
And (LOG_LOGRADOURO.LOC_NU_SEQUENCIAL)=Log_localidade.LOC_NU_SEQUENCIAL)
AND ((LOG_LOGRADOURO.CEP) Like '$Cep') AND ((LOG_LOGRADOURO.UFE_SG)=Log_bairro.UFE_SG
And (LOG_LOGRADOURO.UFE_SG)=Log_localidade.UFE_SG) AND ((LOG_LOGRADOURO.BAI_NU_SEQUENCIAL_INI)=Log_bairro.BAI_NU_SEQUENCIAL))
ORDER BY LOG_LOGRADOURO.LOG_TIPO_LOGRADOURO, LOG_LOGRADOURO.LOG_NO";

$SqlCep = pg_query($Sql);
$ccc = pg_num_rows($SqlCep);

if ($ccc>0){
  $cep = pg_fetch_array($SqlCep);
  //echo "Endereço: $cep[logradouro]<BR>";
  //echo "CEP: $cep[cep]<BR>";
  //echo "Estado: $cep[ufe_sg]<BR>";
  //echo "Cidade: $cep[loc_no]<BR>";
  //echo "Bairro: $cep[inicial]<BR>";
}else{
  $Sql2 = "SELECT LOG_LOCALIDADE.*, LOG_LOCALIDADE.CEP
  FROM LOG_LOCALIDADE
  WHERE LOG_LOCALIDADE.CEP='".$Cep."'";
  $SqlCep2 = pg_query($Sql2);
  $ccc2 = pg_num_rows($SqlCep2);

  if ($ccc2>0){
    $cep = pg_fetch_array($SqlCep2);
    //echo "Cidade: $cep2[loc_no]<BR>";
    //echo "Estado: $cep2[ufe_sg]<BR>";
  }else{
    echo "<center>CEP <b>$Cep</b> não encontrado.</center>";
  }

}
?>
<input type="hidden" name="cep_oculto_entrega" id="cep_oculto_entrega" value="<?php echo $Cep;?>">
<table border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
  <tr>
    <td>Endereço:</td>
    <td><input name="endereco_entrega" id="endereco_entrega" value="<?php echo strtoupper($cep['logradouro']);?>" type="text" size="60" maxlength="50" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.cidade_entrega.focus();}"></td>
  </tr>
  <tr>
    <td>Cidade:</td>
    <td><input name="cidade_entrega" id="cidade_entrega" value="<?php echo strtoupper($cep['loc_no']);?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.bairro_entrega.focus();}"></td>
  </tr>
  <tr>
    <td>Bairro:</td>
    <td><input name="bairro_entrega" id="bairro_entrega" value="<?php echo strtoupper($cep['inicial']);?>" type="text" size="60" maxlength="30" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.estado_entrega.focus();}"></td>
  </tr>
  <tr>
    <td>Estado:</td>
    <td>
      <select name="estado_entrega" size="1" id="estado_entrega" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.cad.telefone_entrega.focus();}">
        <option value="<?php echo strtoupper($cep['ufe_sg']);?>"><?php echo strtoupper($cep['ufe_sg']);?></option>
      		<option value="AC">Acre </option>
      		<option value="AL">Alagoas</option>
      		<option value="AM">Amazonas</option>
      		<option value="AP">Amapa</option>
      		<option value="BA">Bahia</option>
      		<option value="CE">Ceara</option>
      		<option value="DF">Distrito Federal</option>
        <option value="ES">Espirito Santo</option>
      		<option value="GO">Goias</option>
      		<option value="MA">Maranhão</option>
      		<option value="MG">Minas Gerais</option>
      		<option value="MS">Mato G. Sul</option>
      		<option value="MT">Mato Grosso</option>
      		<option value="MA">Maranhão</option>
      		<option value="PA">Para</option>
      		<option value="PR">Parana</option>
      		<option value="PB">Paraiba</option>
      		<option value="PE">Pernambuco</option>
      		<option value="PI">Piaui</option>
      		<option value="RJ">Rio de Janeiro</option>
      		<option value="RN">Rio G. Norte</option>
      		<option value="RO">Rondonia</option>
      		<option value="RR">Roraima</option>
      		<option value="RS">Rio G. Sul</option>
      		<option value="SC">Santa Catarina</option>
      		<option value="SE">Sergipe</option>
        <option value="SP">São Paulo</option>
      		<option value="TO">Tocantins</option>
      </select>
    </td>
  </tr>
  </table>
<?php
pg_close($db2);
?>
