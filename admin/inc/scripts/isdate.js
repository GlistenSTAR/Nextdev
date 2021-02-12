// ********************************************************
// This function accepts a string variable and verifies if
// it is a proper date or not.  It validates format
// matching either mm-dd-yyyy or mm/dd/yyyy. Then it checks
// to make sure the month has the proper number of days,
// based on which month it is.
// The function returns true if a valid date, false if not.
// ********************************************************

function isDate(dateStr) {
   var datePat = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/;
   var matchArray = dateStr.match(datePat); // is format OK?
   if (matchArray == null) {
        alert("Por favor entre com a data no formato dd/mm/yyyy.");
        return false;
   }
   // parse date into variables
   day = matchArray[1];
   month = matchArray[3];
   year = matchArray[5];

   if (month < 1 || month > 12) { // check month range
        alert("O mes deve estar entre 1 e 12.");
        return false;
   }
   if (day < 1 || day > 31) {
        alert("O dia deve estar entre 1 e 31.");
        return false;
   }
   if ((month==4 || month==6 || month==9 || month==11) && day==31) {
        alert("O mes " + month + " nao tem 31 dias!")
        return false;
   }
   if (month == 2) { // check for february 29th
        var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
        if (day > 29 || (day==29 && !isleap)) {
           alert("Fevereiro " + year + " nao tem " + day + " dias!");
           return false;
        }
   }
   return true;  // date is valid
}

