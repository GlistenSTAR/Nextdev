<script language="Javascript" type="text/Javascript">
<!--
var dataHora, xHora, xDia, dia, mes, ano, saudacao;
dataHora = new Date();
xHora = dataHora.getHours();

if (xHora >= 0 && xHora <12) {saudacao = "Bom Dia!"}
if (xHora >= 12 && xHora < 18) {saudacao = "Boa Tarde!"}
if (xHora >= 18 && xHora <= 23) {saudacao = "Boa Noite!"}

xDia = dataHora.getDay();

diaSem = new Array(7);

diaSem[0] = "Domingo";
diaSem[1] = "Segunda-feira";
diaSem[2] = "Terça-feira";
diaSem[3] = "Quarta-feira";
diaSem[4] = "Quinta-feira";
diaSem[5] = "Sexta-feira";
diaSem[6] = "Sábado";

dia = dataHora.getDate();
mes = dataHora.getMonth();

mesAno = new Array(12);

mesAno[0] = "Janeiro";
mesAno[1] = "Fevereiro";
mesAno[2] = "Março";
mesAno[3] = "Abril";
mesAno[4] = "Maio";
mesAno[5] = "Junho";
mesAno[6] = "Julho";
mesAno[7] = "Agosto";
mesAno[8] = "Setembro";
mesAno[9] = "Outubro";
mesAno[10] = "Novembro";
mesAno[11] = "Dezembro";

ano = dataHora.getFullYear();

document.write("<b>" + saudacao + " | Hoje é " + diaSem[xDia] + ", " + dia + " de " + mesAno[mes] + " de " + ano + "</b></font>");
//-->
</script>
