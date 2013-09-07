/**
 * Changed default serializeData to send actual objects to template
 */
define(
    ['marionette', 'application'],
    function(Marionette, App){

        _.extend(Marionette.ItemView.prototype, {
            serializeData: function(){
                return {
                    model: this.model,
                    view: this,
                    app: App
                };
            }
        })

    }
)