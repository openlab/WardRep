var Application = Application || { 'config' : { /* void */ }, 'behaviors' : { /* void */ } };

Application.is_js_enabled = document.getElementsByTagName && document.createElement && document.createTextNode && document.documentElement && document.getElementById;

Application.attach_behaviors = function(context) {
    context = context || document;
    if( Application.is_js_enabled ) {
        for( var k in Application.behaviors ) {
            var that = Application.behaviors[k];
            that(context);
        }
    }
};

Application.get_base_path = function(append_index) {
    return Application.config.base_path;
};

if( Application.is_js_enabled ) {
    $(document).ready(function() {
        Application.attach_behaviors(this);
    });
}