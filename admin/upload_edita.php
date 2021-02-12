<hr></hr>
<table border="0" align="center" cellpadding="2" cellspacing="2" class="texto1" width="100%">
  <tr>
    <?php
    include_once("inc/config.php");
    $uploaddir = "../imagens/";
    $foton = $_FILES[foto_nova]['name'];
    $fotot = $_FILES[foto_nova]['tmp_name'];
    //$uploadfile = $uploaddir.$foton;
    if ($foton){
      if (move_uploaded_file($fotot, $uploaddir . $foton)) {
        $Foto = $foton;
        $Tirar = array("~","'"," ","ç","Ç","ã","Ã","é","É","í","Í","ó","Ó","ú","Ú","õ","Õ","-",",","`","ô","Ô");
        $Foto = str_replace($Tirar, "", $Foto);
        $Foto2 = md5(time()).$Foto;
        $Foto = "imagem='$Foto2', ";
        rename($uploaddir."/".$foton, $uploaddir."/".$Foto2);
        if ($_REQUEST['excluir_antiga']){
          @unlink($uploaddir."/".$_REQUEST['imagem_antiga']);
        }
      }else{
        echo "Erro ao enviar foto $_FILES[foto_nova]['name']<br>";
      }
    }
    if (!$Foto2){
      $Foto2 = "$_REQUEST[imagem_antiga]";
    }
    echo "<td width='100%'>
            <fieldset>
              <legend>Foto $_REQUEST[id]: </legend>
              <table border=0 align=center cellpadding=2 cellspacing=2 class=texto1>
                <tr>
                  <td>
                    <img src='../imagens/$Foto2' width='100' height='100'>
                  </td>
                </tr>
                <tr>
                  <td align='center'>
                    $_REQUEST[legenda]
                  </td>
                </tr>
              </table>
            </fieldset>
          </td>
          ";
    $Grava = " Update imagens set
                 $Foto
                 legenda='$_REQUEST[legenda]'
               Where id='$_REQUEST[id]'
               ";
    pg_query($Grava);
    ?>
  </tr>
</table>

