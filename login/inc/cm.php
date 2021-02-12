<?
if ($_SESSION[usuario]){
  if (!$_SESSION[bd][host]){
    $_SESSION[usuario]=="";
  }else{
    include "config.php";
  }
}
?>
<title><? echo $base;?> - Sistema de Pedidos ON-LINE </title>
<?
if ($_SESSION[usuario]){
  ?>
  <div id="dhtmltooltip"></div>
  <script language="JavaScript" src="inc/menu.js"></script>
  <LINK href="inc/estilos.css" type=text/css rel=stylesheet>
  <LINK href="inc/menu.css" type=text/css rel=stylesheet>
  <script language="JavaScript" src="inc/scripts/funcoes.js"></script>
  <script language="JavaScript" src="inc/scripts/ajax.js"></script>
  <script language="JavaScript" src="inc/scripts/menu.js"></script>
  <script language="JavaScript" src="inc/scripts/iscpfcnpj.js"></script>
  <script language="JavaScript" src="inc/scripts/isempty.js"></script>
  <script language="JavaScript" src="inc/scripts/valores.js"></script>
  <script language="JavaScript" src="inc/scripts/tip.js"></script>
  <script language="JavaScript" src="inc/scripts/calendario.js"></script>
  <link type="text/css" rel="stylesheet" href="inc/css.css" media="screen"></LINK>
  <script language="javascript">
    function imprimir(){
      document.getElementById('naoimprimir').style.display='none';
      document.getElementById('menu').style.display='none';
      //alert(document.getElementById('nao-imprimir').style.display);
      window.print();
      setTimeout("document.getElementById('naoimprimir').style.display='block';",1000);
      setTimeout("document.getElementById('menu').style.display='block';",1000);
    }
    function detbut() {
      var now = new Date();
      var month = now.getMonth() + 1
      var day = now.getDate()
      var year = now.getFullYear()
      var hours = now.getHours();
      var minutes = now.getMinutes();
      var seconds = now.getSeconds()
      var date = (day + "/" + month + "/" + year)
      var timeValue = date + " às " + ((hours >24) ? hours -24 :hours)
      timeValue += ((minutes < 10) ? ":0" : ":") + minutes
      timeValue += ((seconds < 10) ? ":0" : ":") + seconds
      return timeValue;
    }
    function checa(campo, caminho){
      if (campo!="1234567890"){
        if(!isCPFCNPJ(campo,0)){
          //alert("Por favor informe um CPF/CNPJ válido");
          //document.getElementById('Inicio').innerHTML = "Por favor informe um CPF/CNPJ válido";
          Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=0','Conteudo');
          //setTimeout("document.cad.inscricao.focus()",500);
          return false;
        }
        Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=1','Conteudo');
        //setTimeout("document.cad.inscricao.focus()",500);
        return true;
      }else{
        //alert("Por favor informe um CPF/CNPJ válido");
        //document.getElementById('Inicio').innerHTML = "Por favor informe um CPF/CNPJ válido";
        Acha('cadastrar_clientes.php','localizar_numero='+campo+'&cnpj_valido=0','Conteudo');
        //setTimeout("document.cad.inscricao.focus()",500);
        return false;
      }
    }
    function checaCodigo(campo, caminho){
      if(isEmpty(campo,0)){
        alert("Por favor informe o código");
        setTimeout(caminho+".focus()",10);
        return false;
      }
      return true;
    }
    window.onload = function() { preload(); }
    window.document.write("<style type=\"text/css\">#preloader { display: block !important; }</style>");
  </script>
  <?
}
?>
<link href="css.css" rel="stylesheet" type="text/css">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
<div id="preloader"><div id="preloadIMG"><img src="icones/ajax-loader.gif" alt="" /></div></div>
<table width="100%" align="center" cellspacing="0" cellpadding="0">
  <tr>
    <td height="80" valign="top">
      <?
      if ($_SESSION[usuario]){
        ?>
        <div id="menu">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background: #FFFFFF;">
          <tr>
            <td>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="100%" valign="top">
                    <table width="758" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td valign="top">
                          <img src="images/logo2.gif">
                        </td>
                        <td valign="top">
                          <BR><BR>
                          <center>Conectado a <b><? echo $base;?></b></center>
                        </td>
                        <td align="right">
                          <?
                          setlocale(LC_TIME,'pt_BR','ptb');
                          echo  ucfirst(strftime('%A, %d de %B de %Y',mktime(0,0,0,date('n'),date('d'),date('Y'))));
                          echo "<BR><BR>Versão: <b>".$_SESSION['config']['versao']."</b>";
                          ?>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        </div>
        <?
      }
      ?>
    </td>
  </tr>
</table>
