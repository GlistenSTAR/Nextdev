/* Fun��o para carregar div sem refresh */
function GetXMLHttp() {
    if(navigator.appName == "Microsoft Internet Explorer") {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        xmlHttp = new XMLHttpRequest();
    }
    return xmlHttp;
}

var xmlRequest = GetXMLHttp();


/*Fun��o para busca instantanea*/
//pega o objeto ajax do navegador
function xmlhttp()
{
        // XMLHttpRequest para firefox e outros navegadores
        if (window.XMLHttpRequest)
        {
                return new XMLHttpRequest();
        }

        // ActiveXObject para navegadores microsoft
        var versao = ['Microsoft.XMLHttp', 'Msxml2.XMLHttp', 'Msxml2.XMLHttp.6.0', 'Msxml2.XMLHttp.5.0', 'Msxml2.XMLHttp.4.0', 'Msxml2.XMLHttp.3.0','Msxml2.DOMDocument.3.0'];
        for (var i = 0; i < versao.length; i++)
        {
                try
                {
                        return new ActiveXObject(versao[i]);
                }
                catch(e)
                {
                        alert("Seu navegador n�o possui recursos para o uso do AJAX!");
                }
        } // fecha for
        return null;
} // fecha fun��o xmlhttp

//fun��o para fazer a requisi��o da p�gina que efetuar� a consulta no DB
function carregar(){
   a = document.getElementById('busca').value;
   ajax = xmlhttp();
   if (ajax){
   
           ajax.open('get','sql_busca.php?busca='+a, true);
           ajax.onreadystatechange = trazconteudo;
           ajax.send(null);
   }
}

//fun��o para incluir o conte�do na pagina
function trazconteudo(){

        if (ajax.readyState==4){
        
                if (ajax.status==200){
                
                        document.getElementById('resultados').innerHTML = ajax.responseText;
                }
        }
}
