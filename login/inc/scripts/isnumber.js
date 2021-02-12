/*
www.moinho.net
Verify if an string is composed by numbers
Verifica se uma string é composta apenas por números
Fucntion: isNumber
Return : true if the string is composed by numbers
Retorno : true se a string possuir apenas caractéres numéricos
e-mail : celso.goya@moinho.net
Author : Celso Goya

Instructions
If you have any questions about the functionality or sugestions please send us a report.

Instruções
Se você tiver qualquer dúvida ou sugestão sobre a funcionalidade desta função por favor envie-nos um e-mail
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