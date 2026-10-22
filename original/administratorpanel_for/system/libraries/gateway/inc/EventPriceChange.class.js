
function EventPriceChange(currency, price)
{
    var self = this;

    this.currency = currency;
    this.price = price;

    this.getCurrency = function() {
        return this.currency;
    }

    this.getPrice = function() {
        return this.price;
    }


}