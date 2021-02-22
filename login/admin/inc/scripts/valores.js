function BloqueiaLetras(Id, evento)
{
var tecla;
var campo = document.getElementById(Id).value;
    if(window.event) { // Internet Explorer
        tecla = event.keyCode;
    }
    else { // Firefox
        tecla = evento.which;
    }

  if(tecla >= 48 && tecla <= 57 || tecla == 8)
  {
      FormataValor(campo, 10, tecla,Id);
  }
  else
      return false;
}

function FormataValor(valor,tammax,tecla,Id) {
        if (tecla >= 48 && tecla <= 57)
        {
            vr = valor;
            vr = vr.toString().replace( "/", "" );
            vr = vr.toString().replace( "/", "" );
            vr = vr.toString().replace( ",", "" );
            vr = vr.toString().replace( ".", "" );
            vr = vr.toString().replace( ".", "" );
            vr = vr.toString().replace( ".", "" );
            vr = vr.toString().replace( ".", "" );
            tam = vr.length;

            if (tam < tammax && tecla != 8){ tam = vr.length + 1; }

            if (tecla == 8 ){ tam = tam - 1; }

            if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 )
            {
                if ( tam <= 2 )
                {
                    document.getElementById(Id).value = vr;
                }
                if ( (tam > 2) && (tam <= 5) )
                {
                    document.getElementById(Id).value = vr.substr( 0, tam - 2 ) + ',' + vr.substr( tam - 2, tam );
                }
                if ( (tam >= 6) && (tam <= 8) )
                {
                    document.getElementById(Id).value = vr.substr( 0, tam - 5 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
                }
                if ( (tam >= 9) && (tam <= 11) )
                {
                    document.getElementById(Id).value = vr.substr( 0, tam - 8 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
                }
                if ( (tam >= 12) && (tam <= 14) )
                {
                    document.getElementById(Id).value = vr.substr( 0, tam - 11 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
                }
                if ( (tam >= 15) && (tam <= 17) )
                {
                    document.getElementById(Id).value = vr.substr( 0, tam - 14 ) + '.' + vr.substr( tam - 14, 3 ) + '.' + vr.substr( tam - 11, 3 ) + '.' + vr.substr( tam - 8, 3 ) + '.' + vr.substr( tam - 5, 3 ) + ',' + vr.substr( tam - 2, tam );
                }
            }
        }
}
