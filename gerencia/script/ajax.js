/* Função para carregar div sem refresh */
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


/*Função para busca instantanea*/
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
                        alert("Seu navegador não possui recursos para o uso do AJAX!");
                }
        } // fecha for
        return null;
} // fecha função xmlhttp

//função para fazer a requisição da página que efetuará a consulta no DB
function carregar(){
   a = document.getElementById('busca').value;
   ajax = xmlhttp();
   if (ajax){
   
           ajax.open('get','sql_busca.php?busca='+a, true);
           ajax.onreadystatechange = trazconteudo;
           ajax.send(null);
   }
}

//função para incluir o conteúdo na pagina
function trazconteudo(){

        if (ajax.readyState==4){
        
                if (ajax.status==200){
                
                        document.getElementById('resultados').innerHTML = ajax.responseText;
                }
        }
}
