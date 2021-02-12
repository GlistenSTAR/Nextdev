<?php
include_once ("inc/common.php");
include "inc/config.php";
?>
<style>
  .lista {
    font:normal 8pt Arial;
    text-align:left;
    border-left:15px solid #B7BECC;
    width:400px;
  }
</style>
<?php
if ($_REQUEST['tipo']=="cliente"){
  if (strlen($_REQUEST['valor'])>1){
    ?>
    <table width="350">
      <tr>
        <td bgcolor="#FFFFFF" class="lista">
            <?php
            $Valor1 = strtoupper($_REQUEST['valor']);
            $sql = "SELECT cgc, apelido, contato, codigo, nome,inscricao FROM clientes where nome like '%$Valor1%' order by nome limit 10";
            //echo $sql;
            $Listar_Leitura = pg_query($sql);
            $ccc = pg_num_rows($Listar_Leitura);
            if ($ccc<>""){
              echo "<a href='#' onclick=\"Adiciona('','','$_REQUEST[tipo]');\">NENHUM</a><BR>";
              while ($l = pg_fetch_array($Listar_Leitura)){
                $Nome = str_replace($Valor1, "<b>$Valor1</b>", $l['nome']);
                echo "<a href='#' onclick=\"Adiciona('$l[codigo]','$l[nome]','$_REQUEST[tipo]');Adiciona('$l[cgc]','$l[cgc]','$_REQUEST[tipo]cnpj');Adiciona('$l[inscricao]','$l[inscricao]','inscricao');Adiciona('$l[apelido]','$l[apelido]','apelido');Adiciona('$l[contato]','$l[contato]','contato');\">".left($Nome, 60)." - <b>$l[cgc]</b></a><BR>";
              }
            }
            ?>
        </td>
      </tr>
    </table>
    <?php
  }
}else{

}
?>
