<?
$tamanho = filesize("../imagens/$_REQUEST[imagem]");
?>
<link type="text/css" href="lytebox.css"></link>
<script language="JavaScript" src="lytebox.js"></script>
<table cellspading="0" cellspacing="0" border="0" align="center" width="100%" height="100%">
  <tr>
    <td align="center">
      Imagem Miniatura: <i><? echo $_REQUEST[legenda];?></i>
    </td>
  </tr>
  <tr>
    <td align="center">
      <img src='../imagens/media/<? echo $_REQUEST[imagem];?>' border='0'>
    </td>
  </tr>
  <tr>
    <td align="center">
      <hr>
      <a href="down.php?imagem=<? echo $_REQUEST[imagem];?>&i=../imagens/<? echo $_REQUEST[imagem];?>">
        Download imagem em alta resolução
      </a><BR>
      <?
      $Tamanho = intval($tamanho / 1024);
      if ($Tamanho>1024){
        $Tamanho = intval($Tamanho / 1024)." MB";
      }else{
        $Tamanho = $Tamanho." KB";
      }
      ?>
      Tam.: ~ <? echo  $Tamanho;?>
    </td>
  </tr>
</table>
