/**
 * Resource Handler, for easy management of multiple
 * resources that come from a template
 * @param {String} container
 * @param {String} prefix
 */
function ResourceHandler(container, prefix) {
	var self = this;
	this.resources = {};
	this.prefix = prefix;
	
    $(container).getChildren().each(
        function(item) {
            self.resources[item.id] = item.value;
        }
    );
	
	this.get = function(key) {
        if(typeof(this.resources[this.prefix + key]) !== 'undefined') {
            return this.resources[this.prefix + key];
        } else {
            alert('Invalid identifier specified: '+key);
        }
	}
}

/**
 * Image Resource Handler extends ResourceHandler
 * Same as above, only that this adds an image-
 * preloader to the constructor
 * @param {String} container
 * @param {String} prefix
 */
function ImageResourceHandler(container, prefix) {
	this.parent = ResourceHandler;
	this.parent(container, prefix);
	
	var imageObj = new Image();
	
	$each(this.resources,
		function(item) {
			imageObj.src = item;
		}
	);
}