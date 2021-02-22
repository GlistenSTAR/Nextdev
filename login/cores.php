<?php
include_once ("inc/common.php");
include_once("inc/config.php");
if ($_REQUEST['numero_pedido']){
  $_SESSION['UltimoTemCores'] = "SIM";
  $Sql = "Select preto, branco, azul, verde, vermelho, amarelo, marrom, cinza, laranja, rosa, violeta,bege, outra from itens_do_pedido_internet where numero_pedido=".$_REQUEST['numero_pedido']." AND codigo='".$_REQUEST['codigo_cc']."' ";
  $SqlCarregaCores = pg_query($Sql);
  $cores = pg_fetch_array($SqlCarregaCores);
  $Falta = $_REQUEST['qtd_cc'] - ($cores['preto'] +  $cores['branco'] + $cores['azul'] + $cores['verde'] + $cores['vermelho'] + $cores['amarelo'] + $cores['marrom'] + $cores['cinza'] + $cores['laranja'] + $cores['rosa'] + $cores['violeta'] + $cores['bege'] + $cores['outra']);
}
?>
<BR>
<table width="580" height="100" border="0" cellspacing="0" cellpadding="0" class="texto1">
  <tr>
    <td><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td><img src="images/l1_r1_c1.gif" width="603" height="4"></td>
  </tr>
  <tr>
    <td height="214" valign="top" background="images/l1_r2_c1.gif" valign="top">
      <table width="592" height="100" border="0" align="center" cellpadding="0" cellspacing="0" class="texto1">
        <tr>
          <td width="592" colspan="3" valign="top">
            <table width="580" border="0" cellspacing="2" cellpadding="2" class="texto1" align="center">
              <tr>
                <td>
                  <table width = "590" class="texto1">
                    <tr>
                      <td>
                        Escolha das cores do produto codigo: <b><input type="hidden" name="codigo_cores" id="codigo_cores" value="<?php echo $_REQUEST['codigo_cc'];?>"><?php echo $_REQUEST['codigo_cc'];?></b>
                      </td>
                      <td>
                        Quantidade requisitada: <b><input type="hidden" name="qtd_cores" id="qtd_cores" value="<?php echo $_REQUEST['qtd_cc'];?>"><?php echo $_REQUEST['qtd_cc'];?></b>
                      </td>
                      <td>
                        Pedido: <b><input type="hidden" name="numero_cores" id="numero_cores" value="<?php echo $_REQUEST['numero_pedido'];?>"><?php echo $_REQUEST['numero_pedido'];?></b>
                      </td>
                    </tr>
                  </table>
                  <hr>
                  <table width = "590" class="texto1">
                    <tr>
                       <td>Preto:</td>
                       <td><input name="preto" id="preto" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['preto'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.branco.focus();}"></td>
                       <td>Branco:</td>
                       <td><input name="branco" id="branco" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['branco'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.azul.focus();}"></td>
                       <td>Azul:</td>
                       <td><input name="azul" id="azul" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['azul'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.verde.focus();}"></td>
                    </tr>
                    <tr>
                       <td>Verde:</td>
                       <td><input name="verde" id="verde" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['verde'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.vermelho.focus();}"></td>
                       <td>Vermelho:</td>
                       <td><input name="vermelho" id="vermelho" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['vermelho'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.amarelo.focus();}"></td>
                       <td>Amarelo:</td>
                       <td><input name="amarelo" id="amarelo" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['amarelo'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.marrom.focus();}"></td>
                    </tr>
                    <tr>
                       <td>Marrom:</td>
                       <td><input name="marrom" id="marrom" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['marrom'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.cinza.focus();}"></td>
                       <td>Cinza:</td>
                       <td><input name="cinza" id="cinza" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['cinza'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.laranja.focus();}"></td>
                       <td>Laranja:</td>
                       <td><input name="laranja" id="laranja" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['laranja'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.rosa.focus();}"></td>
                    </tr>
                    <tr>
                       <td>Rosa:</td>
                       <td><input name="rosa" id="rosa" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['rosa'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.violeta.focus();}"></td>
                       <td>Violeta:</td>
                       <td><input name="violeta" id="violeta" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['violeta'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.bege.focus();}"></td>
                       <td>Bege:</td>
                       <td><input name="bege" id="bege" type="text" size="18" onfocus="this.select()" onblur="cores();" value="<?php echo $cores['bege'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.outra.focus();}"></td>
                    </tr>
                    <tr>
                       <td colspan="3">Outra:</td>
                       <td colspan="3"><input name="outra" id="outra" type="text" size="18" onblur="cores();" value="<?php echo $cores['outra'];?>" onkeyup="if (window.event){tecla = window.event.keyCode;}else{tecla = event.which;}if(tecla==13){document.ped.gravar_cores.focus();}"></td>
                    </tr>
                    <tr>
                       <td colspan="6"><hr></hr></td>
                    </tr>
                    <tr>
                       <td colspan="3">Falta escolher:</td>
                       <td colspan="3">
                         <input type="hidden" name="falta_cores1" id="falta_cores1" value="<?php echo $Falta;?>">
                         <span id="falta_cores"><?php echo $Falta;?></span>
                       </td>
                    </tr>
                    <tr>
                       <td colspan="6">
                         <input name="gravar_cores" id="gravar_cores" type="button" value="Gravar" onclick="gravacores(true);">
                         <input name="cancelar_cores" id="cancelar_cores" type="button" value="Cancelar" onclick="gravacores(false);">
                       </td>
                    </tr>
                    <tr>
                       <td colspan="6">
                         <div id="confere_cores" style="position: absolute; background-color: none; border: 2px #000000; color: #FFFFFF; z-index:6000;"></div>
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
    <script>
    document.ped.preto.focus();
    </script>
