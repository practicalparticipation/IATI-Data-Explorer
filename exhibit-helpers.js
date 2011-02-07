/**
 Helper functions to IATI Exhibit. Compiled by tim@practicalparticipation.co.uk; February 2011. 
**/


/**
Currency formatting taken from http://www.mail-archive.com/general@simile.mit.edu/msg03590.html
**/

 Exhibit.Formatter._CurrencyFormatter.prototype.formatText =
     function(value) {
       var number;
       if (this._decimalDigits == -1) {
         number = value.toString();
       }
       else {
         number = new Number(value).toFixed(this._decimalDigits);
       }
       number = addCommas(number);
       return number;
     };

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


function filterBy(prop, a) {
        var value = a.innerHTML;
	alert(value);
	Exhibit.getComponent("textSearch-facet").applyRestrictions({ 
selection: [ value ], selectMissing: false});;
}
