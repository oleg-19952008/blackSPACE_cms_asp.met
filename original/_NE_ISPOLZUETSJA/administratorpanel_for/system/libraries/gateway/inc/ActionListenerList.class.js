
function ActionListenerList()
{
    var self = this;
    this.list = new Array();
    this.objectList = new Array();


    this.add = function(object, method) {
        if (method == 'undefined') {
            this.list.push(object);
        }

        if (object && method) {
            this.objectList.push(
                new Hash({object: object, method: method})
            );
        }
    }

    this.throwEvent = function(event) {
        this.list.each(function(item, index) {
            item(event);
        });

        this.objectList.each(function(item, index) {
            var obj = item.get('object');
            var methodname = item.get('method');
            obj[methodname](event);
        });
    }


}