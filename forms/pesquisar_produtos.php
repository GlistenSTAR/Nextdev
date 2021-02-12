<?php
include_once ("../inc/common.php");
include "../inc/verifica.php";
include_once "../inc/config.php";
if (!$_REQUEST['descricao_pesquisa_id']){
  ?>
  <div id="produtos">
    <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
      <tr>
        <td><img src="images/spacer.gif" width="1" height="3"></td>
      </tr>
      <tr>
        <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
      </tr>
      <tr>
        <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
          <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
            <tr>
              <td width="592" colspan="3" valign="top">
                <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                  <tr>
                    <td>
                      <table border ="0" widht="50%" height="50" class="texto1" align="center">
                        <tr>
                          <td colspan="2" align="center">Selecione o produto:</td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><BR><BR></td>
                        </tr>
                        <tr>
                          <td width="20%">Código:</td>
                          <td width="80%">
                            <input type="text" size="20" name="codigo_pesquisa_cc" maxlength="18" id="codigo_pesquisa_cc" value="<?php echo $_REQUEST['codigo_pesquisa'];?>" onfocus="this.select()" onkeyup="if (this.value.length>2){Acha1('listar.php','tipo=descricao_pesquisa&valor='+this.value+'&pesquisa=codigo','listar_codigo_pesquisa');}">
                            <BR>
                            <div id="listar_codigo_pesquisa" style="position:absolute; z-index: 7000;"></div>
                          </td>
                        </tr>
                        <tr>
                          <td width="20%">Descrição:</td>
                          <td width="80%">
                            <input type="hidden" name="descricao_pesquisa_id" id="descricao_pesquisa_id">
                            <input type="text" size="60" name="descricao_pesquisa_cc" id="descricao_pesquisa_cc" onfocus="this.select()" onkeyup=" if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if (tecla == '38'){ getPrevNode('1');}else if (tecla == '40'){ getProxNode('1');}else if (tecla == '13'){ acerta_campos('produtos','Conteudo','forms/pesquisar_produtos.php',true); }else { Acha1('listar.php','tipo=descricao_pesquisa&valor='+this.value+'','listar_descricao_pesquisa');}">
                            <BR>
                            <div id="listar_descricao_pesquisa" style="position:absolute; z-index: 7000;"></div>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><BR><BR><BR></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center">
                            <input name="consultar" id="consultar" type="button" value="Consultar" onclick="acerta_campos('produtos','Conteudo','forms/pesquisar_produtos.php',true);">
                            <input value="Voltar" name="Voltar" id="Voltar" type="button" onclick="Acha('inicio.php','','Conteudo');">
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
      </tr>
    </table>
  </div>
  <?php
}else{
  $AchaProduto = pg_query("SELECT p.codigo, p.nome, p.preco_venda, p.ipi, p.classificacao_fiscal, p.peso_liquido, p.ncm ,e.estocada, e.reservado FROM produtos AS p INNER JOIN estoques AS e ON e.codigo = p.codigo WHERE p.codigo='".$_REQUEST['descricao_pesquisa_id']."'");
		$p = pg_fetch_array($AchaProduto);
  ?>
  <table width="580" height="300" border="0" cellspacing="0" cellpadding="0" class="texto1">
    <tr>
      <td><img src="images/spacer.gif" width="1" height="3"></td>
    </tr>
    <tr>
      <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
    </tr>
    <tr>
      <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
        <table width="592" height="350" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
          <tr>
            <td width="592" colspan="3" valign="top">
              <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
                <tr>
                  <td>
                    <table width="100%" class="texto1">
                      <tr>
                        <td align=center><h4>Código:<i></td><td> <b><?php echo $p['codigo'];?></b></i></h4></td>
                      </tr>
                      <tr>
                        <td align=center><b>Produto:</b></td><td>  <?php echo $p['nome'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>Valor Unit.:</b></td><td>  <?php echo $p['preco_venda'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>IPI:</b></td><td>  <?php echo $p['ipi'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>NCM:</b></td><td>  <?php echo $p['ncm'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>Peso líquido:</b></td><td>  <?php echo $p['peso_liquido'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>Class. Fiscal:</b></td><td>  <?php echo $p['classificacao_fiscal'];?></td>
                      </tr>
                      <tr>
                        <td align=center><b>Qtd. Estoque:</b></td><td>  <?php echo $p['estocada'] - $p['reservado'];?></td>
                      </tr>																						
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td align="center"><input value="Voltar" name="Voltar" type="button" onclick="Acha('forms/pesquisar_produtos.php','','Conteudo');"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td><img src="images/l1_r4_c1.gif" width="603" height="4"><BR></td>
    </tr>
  </table>
  <?php
}
?>
