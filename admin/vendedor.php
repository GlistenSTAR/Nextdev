<?
include ("inc/verifica.php");
?>
<table class="adminform" align="center" width="100%" height="350">
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<img src="<? echo $site_url;?>icones/usuarios.png" border="0" align="left">
      <center><h3>Gerenciar vendedores</h3></center><hr></hr>
    </td>
  </tr>
  <tr>
    <td align="center" valign="top"><img src="images/spacer.gif" width="1" height="3"></td>
  </tr>
  <tr>
    <td align="center" valign="top">
      <table align="center" cellspacing="10" cellpadding="10">
        <tr>
          <td>
            <div id="cpanel">
              <div style="float: center;">
               	<div class="icon">
                 	<a  href="#" onclick="Acha('cadastrar_vendedor.php','','Conteudo');">
               		  	<img src="icones/cadastrar.png" alt="Adicionar vendedor" align="middle" border="0">
                    <span class="texto1">Cadastrar</span>
               			</a>
               	</div>
              </div>
            </div>
          </td>
          <td>
            <div id="cpanel">
              <div style="float: center;">
               	<div class="icon">
                 	<a  href="#" onclick="Acha('listar_vendedor.php','','Conteudo');">
               		  	<img src="icones/listar.gif" alt="Listar notícias" align="middle" border="0">
                    <span class="texto1">Listar</span>
               			</a>
               	</div>
              </div>
            </div>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
