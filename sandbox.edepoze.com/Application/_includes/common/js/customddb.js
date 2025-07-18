var CustomDDB = function() {
    this.ids = {};

    this.hasControls = false;

    this.initialize = function(id) {
        if (!controls.$(id)) return;
        this.ids[id] = id;
        if (!this.hasControls) controls.addEvent(document.body, 'click', function() {
            var ar = controls.query('._custom_select_list');
            for (var i = 0; i < ar.length; i++) controls.display(ar[i], 'none');
        });
        this.hasControls = true;
        //controls.addEvent('val_' + id, 'click', click);
        //controls.addEvent('select_' + id, 'click', click);
        /*setInterval(function()
	   {
	     if (!controls.$('container_' + id)) return;
		    if (controls.hasClass(id, 'validate')) 
		    {
		      controls.addClass('container_' + id, 'validate');
	     } 
		    else 
		    {
		      controls.removeClass('container_' + id, 'validate');
	     }
	   }, 200);*/
    };

    this.select = function(id, value, option) {
        controls.$(id).value = value;
        controls.$('val_' + id).innerHTML = option;
        controls.display('list_' + id, 'none');
    }

    this.open = function(id, e) {
        var display = controls.getStyle('list_' + id, 'display');
        for (var uid in this.ids)
            if (controls.$('list_' + uid)) controls.display('list_' + uid, 'none');
        controls.display('list_' + id, (display == 'none') ? 'block' : 'none');
        controls.stopEvent(e || event);
    }
};

var cddb = new CustomDDB();