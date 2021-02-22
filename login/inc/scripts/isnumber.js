/*
www.moinho.net
Verify if an string is composed by numbers
Verifica se uma string � composta apenas por n�meros
Fucntion: isNumber
Return : true if the string is composed by numbers
Retorno : true se a string possuir apenas caract�res num�ricos
e-mail : celso.goya@moinho.net
Author : Celso Goya

Instructions
If you have any questions about the functionality or sugestions please send us a report.

Instru��es
Se voc� tiver qualquer d�vida ou sugest�o sobre a funcionalidade desta fun��o por favor envie-nos um e-mail
*/
function isNumber(numero){
   var CaractereInvalido = false;

   for (i=0; i < numero.length; i++){
      var Caractere = numero.charAt(i);
      if(Caractere != "." && Caractere != "," && Caractere != "-"){
         if (isNaN(parseInt(Caractere))) CaractereInvalido = true;
      }
   }
   return !CaractereInvalido;
}