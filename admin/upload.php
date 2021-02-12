<hr></hr>
<table border="0" align="center" cellpadding="2" cellspacing="2" class="texto1" width="100%">
  <tr>
    <?
    include_once("inc/config.php");
    $qtd_fotos = $_POST["qtd_fotos"];
    $uploaddir = "../imagens/";
    $max = "4"; //qtd de fotos por linha
    $Width= 100 / $max;
    for ($i=1;$i<=$qtd_fotos;$i++){
      //peguei isso pra não gerar um array, método brasileiro de programação.
      $foto = "f$i";
      $leg = "l$i";
      $Legenda = "$_POST[$leg]";;
      $foton = $_FILES[$foto]['name'];
      $fotot = $_FILES[$foto]['tmp_name'];
      //$uploadfile = $uploaddir.$foton;
      if (move_uploaded_file($fotot, $uploaddir . $foton)) {
        $Foto = $foton;
        $Tirar = array("~","'"," ","ç","Ç","ã","Ã","é","É","í","Í","ó","Ó","ú","Ú","õ","Õ","-",",","`","ô","Ô");
        $Foto = str_replace($Tirar, "", $Foto);
        $Foto2 = md5(time()).$Foto;
        $Foto = $Foto2;
        rename($uploaddir."/".$foton, $uploaddir."/".$Foto2);
        $Grava = "Insert Into imagens (
                                         imagem,
                                         legenda,
                                         data,
                                         ativo
                                       ) VALUES(
                                         '$Foto',
                                         '$Legenda',
                                         '$data_hoje',
                                         '1'
                                       )";
        pg_query($Grava);
        echo "<td width='$Width%'>
                <fieldset>
                  <legend>Foto $i: </legend>
                  <table border=0 align=center cellpadding=2 cellspacing=2 class=texto1>
                    <tr>
                      <td>
                        <img src='../imagens/$Foto' width='100' height='100' onclick=\"window.open('imprimir_clientes.php','_blank')\">
                      </td>
                    </tr>
                    <tr>
                      <td align='center'>
                        $Legenda
                      </td>
                    </tr>
                  </table>
                </fieldset>
              </td>
              ";
        $atual=$atual+1;
        if ($atual==$max){
          echo "</tr><tr>";
          $atual = "0";
        }
      }else{
        echo "Erro ao enviar foto $_FILES[$foto]['name']<br>";
      }
    }
    ?>
  </tr>
</table>

