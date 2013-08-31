/**
 * Changed default serializeData to send actual objects to template
 */
define(
    ['marionette'],
    function(Marionette){

        _.extend(Marionette.ItemView.prototype, {
            serializeData: function(){
                return {
                    model: this.model,
                    view: this
                };
            }
        })

    }
)