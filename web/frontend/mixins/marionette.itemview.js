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