function ajax() {
};
ajax.prototype.iniciar = function() {

    try{
        this.xmlhttp = new XMLHttpRequest();
    }catch(ee){
        try{
            this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        }catch(e){
            try{
                this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }catch(E){
                this.xmlhttp = false;
            }
        }
    }
    return true;
}

ajax.prototype.ocupado = function() {
    estadoAtual = this.xmlhttp.readyState;
    return (estadoAtual && (estadoAtual < 4));
}

ajax.prototype.processa = function() {
    if (this.xmlhttp.readyState == 4 && this.xmlhttp.status == 200) {
        return true;
    }
}

ajax.prototype.enviar = function(url, metodo, modo) {
    if (!this.xmlhttp) {
        this.iniciar();
    }
    if (!this.ocupado()) {
        if(metodo == "GET") {
            this.xmlhttp.open("GET", url, modo);
            this.xmlhttp.send(null);
        } else {
            this.xmlhttp.open("POST", url, modo);
            this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
            this.xmlhttp.setRequestHeader("Cache-Control", "no-store, no-cache, must-revalidate");
            this.xmlhttp.setRequestHeader("Cache-Control", "post-check=0, pre-check=0");
            this.xmlhttp.setRequestHeader("Pragma", "no-cache");
            this.xmlhttp.send(url);
        }

        if (this.processa) {
            return unescape(this.xmlhttp.responseText.replace("+/+/g+"," "));
        }
    }
    return false;
}

function editar(id) {
  elem = document.getElementById('campo'+id); //primeiro campo
  elem2 = document.getElementById('campo_'+id); //segundo campo
  bot = document.getElementById("enviar"+id); //botao de enviar
  elem.innerHTML = "<input type=text value=" + elem.innerHTML + " id='"+id+"_c' />"; //inserir o primeiro input
  elem2.innerHTML = "<input type=text value=" + elem2.innerHTML + " id='"+id+"d_c' />"; //inserir o segundo input
  bot.innerHTML = "<a href='#' onclick=editado('"+ id +"');>enviar</a>"; //inserir o botao de enviar a alteracao
}

function editado(id) {
    envia = document.getElementById('enviar'+id); //span onde vai aparecer o botaozinho para enviar a alteracao
    campo = document.getElementById(id+'_c').value; //primeiro campo
    campod = document.getElementById(id+'d_c').value; //segundo campo
    ecampo = escape(campo); //para não haver problemas de acentos e tal
    ecampod = escape(campod); //para não haver problemas de acentos e tal
    document.getElementById('campo'+id).innerHTML = campo; //alterar o registro na pagina
    document.getElementById('campo_'+id).innerHTML = campod; //alterar o registro na pagina
    envia.innerHTML = "<a href='#' onclick='editar('"+id+"')'>alterar</a>"; //depois de enviar, mostrar de novo o botão de editar
    xmlhttp = new ajax();
    xmlhttp.enviar('executa.php?acao=edit&id='+ id + '&nome='+ ecampo + '&sobrenome=' + ecampod, "POST", false); //endereco para enviar a alteração
}

function addrow(id) {
    também = document.getElementById('tabela'); //id da tabela
    campo = document.getElementById('nome'); //primeiro campo
    campod = document.getElementById('sobrenome'); //segundo campo

    var x=também.insertRow(-1); //inserir a linha
    var y=x.insertCell(0); //inserir coluna 1
    var z=x.insertCell(1); //inserir coluna 2
    var w=x.insertCell(2); //inserir coluna 3
    var b=x.insertCell(3); //inserir coluna 4

    y.innerHTML=id; //na primeira coluna, inserir o id
    z.innerHTML="<span id='campo"+id+"'>"+campo.value+"</span>"; //na segunda coluna, inserir o nome
    w.innerHTML="<span id='campo_"+id+"'>"+campod.value+"</span>"; //na terceira coluna, inserir o sobrenome
    b.innerHTML="<span id='enviar"+id+"'><a href='#' onclick='editar('"+id+"')'>alterar</a></span><br><a href='#' onClick='deleterow('"+id+"', this.parentNode.parentNode.rowIndex);'>del</a>"; //na quarta coluna, inserir as opções
}

function add() {
    campo = document.getElementById('nome').value; //recupera primeiro campo
    ecampo = escape(campo); //"escapa" primeiro campo
    campod = document.getElementById('sobrenome').value; //recupera segundo campo
    ecampod = escape(campod);//"escapa" segundo campo
    xmlhttp = new ajax();
    id = xmlhttp.enviar('executa.php?acao=add&nome='+ ecampo + '&sobrenome=' + ecampod, "POST", false); //manda adicionar
    addrow(id); //adiciona a linha com os campos
    campo.value = ""; //limpa o campo 1
    campod.value = ""; //limpa o campo2
}

function apagar(id, rowIndex)
{
    if (confirm('Tem certeza que deseja excluir este registro?'))
    {
        document.getElementById("tabela").deleteRow(rowIndex); //id da tabela + excluir linha
        xmlhttp = new ajax();
        xmlhttp.enviar('executa.php?acao=del&id='+ id, "POST", false); //envia o comando para deletar
    }
}
