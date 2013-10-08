define(
    [],
    function(){
        _.mixin({

            currencyFormat: function(value, showCurrency){
                var formattedValue = parseFloat(value);

                formattedValue = Math.round(formattedValue, 2);
                var DecimalSeparator = Number("1.2").toLocaleString().substr(1,1);

                var AmountWithCommas = formattedValue.toLocaleString();
                var arParts = String(AmountWithCommas).split(DecimalSeparator);
                var intPart = arParts[0];
                var decPart = (arParts.length > 1 ? arParts[1] : '');
                decPart = (decPart + '00').substr(0,2);

                if( formattedValue == 0 ){
                    formattedValue = '-';
                }else{
                    formattedValue = intPart + DecimalSeparator + decPart;
                    showCurrency = _.isUndefined(showCurrency)?true:showCurrency;
                    if (showCurrency) {
                        formattedValue += " руб.";
                    }
                }

                return formattedValue;

            }

        })
    }
)