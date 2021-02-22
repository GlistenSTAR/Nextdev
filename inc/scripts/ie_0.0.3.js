 /*
@summary: Valida a inscrição estadual de qualquer estado brasileiro.
@return: True se a inscrição estadual é valida para o estado fornecido, senão retorna False.
@use:
 if (CheckIE(InscricaoEstadual, EstadoDaMesma))
   alert('Inscrição Estadual correta.');
 else
   alert('Inscrição Estadual errada.');
*/

var OrdZero = '0'.charCodeAt(0);

function CharToInt(ch){
 return ch.charCodeAt(0) - OrdZero;
}

function IntToChar(intt){
 return String.fromCharCode(intt + OrdZero);
}

function CheckIEAC(ie){
  if (ie){
  if (ie.length != 13)
   return false;
  var b = 4, soma = 0;

  for (var i = 0; i <= 10; i++){
   soma += CharToInt(ie.charAt(i)) * b;
   --b;
   if (b == 1) { b = 9; }
  }
  dig = 11 - (soma % 11);
  if (dig >= 10) { dig = 0; }
  resultado = (IntToChar(dig) == ie.charAt(11));
  if (!resultado) { return false; }

  b = 5;
  soma = 0;
  for (var i = 0; i <= 11; i++){
   soma += CharToInt(ie.charAt(i)) * b;
   --b;
   if (b == 1) { b = 9; }
  }
  dig = 11 - (soma % 11);
  if (dig >= 10) { dig = 0; }
  if (IntToChar(dig) == ie.charAt(12)) { return true; } else { return false; }
} //AC

function CheckIEAL(ie){
 if (ie.length != 9)
  return false;
 var b = 9, soma = 0;
 for (var i = 0; i <= 7; i++){
   soma += CharToInt(ie.charAt(i)) * b;
   --b;
 }
 soma *= 10;
 dig = soma - Math.floor(soma / 11) * 11;
 if (dig == 10) { dig = 0; }
 return (IntToChar(dig) == ie.charAt(8));
} //AL

function CheckIEAM(ie){
 if (ie.length != 9)
  return false;
 var b = 9, soma = 0;
 for (var i = 0; i <= 7; i++){
  soma += CharToInt(ie.charAt(i)) * b;
  b--;
 }
 if (soma < 11) {
   dig = 11 - soma;
 }else{
   i = soma % 11;
   if (i <= 1) { dig = 0; } else { dig = 11 - i; }
 }
 return (IntToChar(dig) == ie.charAt(8));
} //am

function CheckIEAP(ie){
 if (ie.length != 9)
  return false;
 var p = 0, d = 0, i = ie.substring(1, 8);
 if ((i >= 3000001) && (i <= 3017000)){
   p =5;
   d = 0;
 }else if ((i >= 3017001) && (i <= 3019022)){
   p = 9;
   d = 1;
 }
 b = 9;
 soma = p;
 for (var i = 0; i <= 7; i++){
  soma += CharToInt(ie.charAt(i)) * b;
  b--;
 }
 dig = 11 - (soma % 11);
 if (dig == 10){
   dig = 0;
 }else if (dig == 11){
   dig = d;
 }
 return (IntToChar(dig) == ie.charAt(8));
} //ap

function CheckIEBA(ie){
 if (ie.length != 8)
  return false;
 die = ie.substring(0, 8);
 var nro = new Array(8);
 var dig = -1;
 for (var i = 0; i <= 7; i++){
  nro[i] = CharToInt(die.charAt(i));
 }
 var NumMod = 0;
 if (String(nro[0]).match(/[0123458]/))
   NumMod = 10;
 else
   NumMod = 11;
 b = 7;
 soma = 0;
 for (i = 0; i <= 5; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % NumMod;
 if (NumMod == 10){
  if (i == 0) { dig = 0; } else { dig = NumMod - i; }
 }else{
  if (i <= 1) { dig = 0; } else { dig = NumMod - i; }
 }
 resultado = (dig == nro[7]);
 if (!resultado) { return false; }
 b = 8;
 soma = 0;
 for (i = 0; i <= 5; i++){
  soma += nro[i] * b;
  b--;
 }
 soma += nro[7] * 2;
 i = soma % NumMod;
 if (NumMod == 10){
  if (i == 0) { dig = 0; } else { dig = NumMod - i; }
 }else{
  if (i <= 1) { dig = 0; } else { dig = NumMod - i; }
 }
 return (dig == nro[6]);
} //ba

function CheckIECE(ie){
 if (ie.length > 9)
  return false;
 die = ie;
 if (ie.length < 9){
  while (die.length <= 8)
   die = '0' + die;
 }
 var nro = Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(die[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 dig = 11 - (soma % 11);
 if (dig >= 10)
  dig = 0;
 return (dig == nro[8]);
} //ce

function CheckIEDF(ie)
{
 if (ie.length != 13)
  return false;
 var nro = new Array(13);
 for (var i = 0; i <= 12; i++)
  nro[i] = CharToInt(ie[i]);
 b = 4;
 soma = 0;
 for (i = 0; i <= 10; i++){
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 9;
 }
 dig = 11 - (soma % 11);
 if (dig >= 10)
  dig = 0;
 resultado = (dig == nro[11]);
 if (!resultado)
  return false;
 b = 5;
 soma = 0;
 for (i = 0; i <= 11; i++){
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 9;
 }
 dig = 11 - (soma % 11);
 if (dig >= 10)
  dig = 0;
 return (dig == nro[12]);
}
function CheckIEES(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i < 2)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
}

function CheckIEGO(ie){
 if (ie.length != 9)
  return false;
 s = ie.substring(0, 2);
 if ((s == '10') || (s == '11') || (s == '15')){
  var nro = new Array(9);
  for (var i = 0; i <= 8; i++)
   nro[i] = CharToInt(ie[i]);
  n = Math.floor(ie / 10);
  if (n = 11094402){
   if ((nro[8] == 0) || (nro[8] == 1))
    return true;
  }
  b = 9;
  soma = 0;
  for (i = 0; i <= 7; i++){
   soma += nro[i] * b;
   b--;
  }
  i = soma % 11;
  if (i == 0)
   dig = 0;
  else{
   if (i == 1){
    if ((n >= 10103105) && (n <= 10119997))
     dig = 1;
    else
     dig = 0;
   }
   else
    dig = 11 - i;
  }
  return (dig == nro[8]);
 }
}

function CheckIEMA(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
}

function CheckIEMT(ie){
 if (ie.length < 9)
  return false;
 die = ie;
 if (die.length < 11){
  while (die.length <= 10)
   die = '0' + die;
  var nro = new Array(11);
  for (var i = 0; i <= 10; i++)
   nro[i] = CharToInt(die[i]);
  b = 3;
  soma = 0;
  for (i = 0; i <= 9; i++){
   soma += nro[i] * b;
   b--;
   if (b == 1)
    b = 9;
  }
  i = soma % 11;
  alert(soma);
  if (i <= 1)
   dig = 0;
  else
   dig = 11 - i;
  return (dig == nro[10]);
 }
} //mt

function CheckIEMS(ie){
 if (ie.length != 9)
  return false;
 if (ie.substring(0,2) != '28')
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
} //ms

function CheckIEPA(ie){
 if (ie.length != 9)
  return false;
 if (ie.substring(0, 2) != '15')
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
} //pa

function CheckIEPB(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
} //pb

function CheckIEPR(ie){
 if (ie.length != 10)
  return false;
 var nro = new Array(10);
 for (var i = 0; i <= 9; i++)
  nro[i] = CharToInt(ie[i]);
 b = 3;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 resultado = (dig == nro[8]);
 if (!resultado)
  return false;
 b = 4;
 soma = 0;
 for (i = 0; i <= 8; i++){
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[9]);
} //pr

function CheckIEPE(ie){
 if (ie.length != 14)
  return false;
 var nro = new Array(14);
 for (var i = 0; i <= 13; i++)
  nro[i] = CharToInt(ie[i]);
 b = 5;
 soma = 0;
 for (i = 0; i <= 12; i++){
  soma += nro[i] * b;
  b--;
  if (b == 0)
   b = 9;
 }
 dig = 11 - (soma % 11);
 if (dig > 9)
  dig = dig - 10;
 return (dig == nro[13]);
} //pe

function CheckIEPI(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
} //pi

function CheckIERJ(ie){
 if (ie.length != 8)
  return false;
 var nro = new Array(8);
 for (var i = 0; i <= 7; i++)
  nro[i] = CharToInt(ie[i]);
 b = 2;
 soma = 0;
 for (i = 0; i <= 6; i++){
  soma += nro[i] * b;
  b--;
  if (b == 1)
   b = 7;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[7]);
} //rj
function CheckIERN(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 soma *= 10;
 dig = soma % 11;
 if (dig == 10)
  dig = 0;
 return (dig == nro[8]);
} //rn

function CheckIERS(ie){
 if (ie.length != 10)
  return false;
 i = ie.substring(0, 3);
 if ((i >= 1) && (i <= 467)){
  var nro = new Array(10);
  for (var i = 0; i <= 9; i++)
   nro[i] = CharToInt(ie[i]);
  b = 2;
  soma = 0;
  for (i = 0; i <= 8; i++){
   soma += nro[i] * b;
   b--;
   if (b == 1)
    b = 9;
  }
  dig = 11 - (soma % 11);
  if (dig >= 10)
   dig = 0;
  return (dig == nro[9]);
 } //if i&&i
} //rs

function CheckIEROantiga(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 6;
 soma = 0;
 for (i = 3; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 dig = 11 - (soma % 11);
 if (dig >= 10)
  dig = dig - 10;
 return (dig == nro[8]);
} //ro-antiga


function CheckIERO(ie){
 var i = 1, y = 6, x = 0, z = 0;
 var s = '';
 for (var j = 0; j <= (ie.length - 1); j++)
  if (String(ie[j]).match(/[0123456789]/))
   s += ie[j];
 if (s.length == 14)
  for (var i = 0; i < (14 - s.length); i++)
   s = '0' + s;
 for (i = 0; i <= (s.length - 2); i++){
  x = s[i] * y;
  z += x;
  if (y > 2)
   y--;
  else
   y = 9;
 }
 x = z % 11;
 y = 11 - x;
 if (y == s[13])
  return true;
 else
  return false;
} //ro nova

function CheckIERR(ie){
 if (ie.length != 9)
  return false;
 if (ie.substring(0,2) != '24')
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 var soma = 0;
 var n = 0;
 for (i = 0; i <= 7; i++)
  soma += nro[i] * ++n;
 dig = soma % 9;
 return (dig == nro[8]);
} //rr

function CheckIESC(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 i = soma % 11;
 if (i <= 1)
  dig = 0;
 else
  dig = 11 - i;
 return (dig == nro[8]);
} //sc

function CheckIESP(ie){
 if (((ie.substring(0,1)).toUpperCase()) == 'P'){
   s = ie.substring(1, 9);
   var nro = new Array(12);
   for (var i = 0; i <= 7; i++)
    nro[i] = CharToInt(s[i]);
   soma = (nro[0] * 1) + (nro[1] * 3) + (nro[2] * 4) + (nro[3] * 5) +
          (nro[4] * 6) + (nro[5] * 7) + (nro[6] * 8) + (nro[7] * 10);
   dig = soma % 11;
   if (dig >= 10)
    dig = 0;
   resultado = (dig == nro[8]);
   if (!resultado)
    return false;
 }else{
  if (ie.length < 12)
   return false;
  else if (ie.length > 12)
   return false;
  var nro = new Array(12);
  for (var i = 0; i <= 11; i++)
   nro[i] = CharToInt(ie[i]);
  soma = (nro[0] * 1) + (nro[1] * 3) + (nro[2] * 4) + (nro[3] * 5) +
         (nro[4] * 6) + (nro[5] * 7) + (nro[6] * 8) + (nro[7] * 10);
  dig = soma % 11;
  if (dig >= 10)
   dig = 0;
  resultado = (dig == nro[8]);
  if (!resultado)
   return false;
  soma = (nro[0] * 3) + (nro[1] * 2) + (nro[2] * 10) + (nro[3] * 9) +
         (nro[4] * 8) + (nro[5] * 7) + (nro[6] * 6)  + (nro[7] * 5) +
         (nro[8] * 4) + (nro[9] * 3) + (nro[10] * 2);
  dig = soma % 11;
  if (dig >= 10)
   dig = 0;
  return (dig == nro[11]);
 }
} //sp

function CheckIESE(ie){
 if (ie.length != 9)
  return false;
 var nro = new Array(9);
 for (var i = 0; i <= 8; i++)
  nro[i] = CharToInt(ie[i]);
 b = 9;
 soma = 0;
 for (i = 0; i <= 7; i++){
  soma += nro[i] * b;
  b--;
 }
 dig = 11 - (soma % 11);
 if (dig >= 10)
  dig = 0;
 return (dig == nro[8]);
} //se

//Em modificação. Estou aguardando retorno da sintegra(site fora do ar) sobre este algoritmo pois mudou
function CheckIETO(ie){
 if (ie.length != 11)
  return false;
 s = ie.substring(2, 2);
 if ((s == '01') || (s == '02') || (s == '03') || (s == '99')){
  var nro = new Array(11);
  for (var i = 0; i <= 10; i++)
   nro[i] = CharToInt(ie[i]);
  b = 9;
  soma = 0;
  for (i = 0; i <= 9; i++){
   if ((i != 3) && (i != 4)){
    soma += nro[i] * b;
    b--;
   }
  }
  i = soma % 11;
  if (i <= 1)
   dig = 0;
  else
   dig = 11 - i;
  return (dig == nro[10]);
 }
} //to

function CheckIEMG(ie){
 if (ie.substring(0,2) == 'PR')
  return true;
 if (ie.substring(0,5) == 'ISENT')
  return true;
 if (ie.length != 13)
  return false;
 dig1 = ie.substring(11, 12);
 dig2 = ie.substring(12, 13);
 insc = ie.substring(0, 3) + '0' + ie.substring(3, 11);
 npos = 11;
 i = 1;
 ptotal = 0;
 psoma = 0;
 while (npos >= 0){
  i++;
  psoma = CharToInt(insc[npos]) * i;
  if (psoma >= 10)
   psoma -= 9;
  ptotal += psoma;
  if (i == 2)
   i = 0;
  npos--;
 }
 nresto = ptotal % 10;
 if (nresto == 0)
  nresto = 10;
 nresto = 10 - nresto;
 if (nresto != CharToInt(dig1))
  return false;
 npos = 11;
 i = 1;
 ptotal = 0;
 while (npos >= 0){
  i++;
  if (i == 12)
   i = 2;
  ptotal += CharToInt(ie[npos]) * i;
  npos--;
 }
 nresto = ptotal % 11;
 if ((nresto == 0) || (nresto == 1))
  nresto = 11;
 nresto = 11 - nresto;
 return (nresto == CharToInt(dig2));
}

function CheckIE(ie, estado){
 alert("hahaha");
 if ((ie!="null") || (estado!="null")){
   ie = ie.replace(/\./g, '');
   ie = ie.replace(/\\/g, '');
   ie = ie.replace(/\-/g, '');
   ie = ie.replace(/\//g, '');
   if ((ie.toUpperCase() == 'ISENTO') || (estado == 'TO')){
     return true;
   }else
     switch (estado){
      case 'MG': return CheckIEMG(ie); break;
      case 'AC': return CheckIEAC(ie); break;
      case 'AL': return CheckIEAL(ie); break;
      case 'AM': return CheckIEAM(ie); break;
      case 'AP': return CheckIEAP(ie); break;
      case 'BA': return CheckIEBA(ie); break;
      case 'CE': return CheckIECE(ie); break;
      case 'DF': return CheckIEDF(ie); break;
      case 'ES': return CheckIEES(ie); break;
      case 'GO': return CheckIEGO(ie); break;
      case 'MA': return CheckIEMA(ie); break;
      case 'MT': return CheckIEMT(ie); break;
      case 'MS': return CheckIEMS(ie); break;
      case 'PA': return CheckIEPA(ie); break;
      case 'PB': return CheckIEPB(ie); break;
      case 'PR': return CheckIEPR(ie); break;
      case 'PE': return CheckIEPE(ie); break;
      case 'PI': return CheckIEPI(ie); break;
      case 'RJ': return CheckIERJ(ie); break;
      case 'RN': return CheckIERN(ie); break;
      case 'RS': return CheckIERS(ie); break;
      case 'RO': return ((CheckIEROantiga(ie)) || (CheckIERO(ie))); break;
      case 'RR': return CheckIERR(ie); break;
      case 'SC': return CheckIESC(ie); break;
      case 'SP': return CheckIESP(ie); break;
      case 'SE': return CheckIESE(ie); break;
      case 'TO': return CheckIETO(ie); break;
     }
   }
 }
}
