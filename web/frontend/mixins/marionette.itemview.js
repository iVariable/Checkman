/**
 * Changed default serializeData to send actual objects to template
 */
define(
    ['marionette', 'application'],
    function(Marionette, App){

        _.extend(Marionette.ItemView.prototype, {
            serializeData: function(){
                var data = {
                    model: this.model,
                    view: this,
                    app: App
                }

                if (!_(this._serializeAdditionalData).isUndefined()){
                    _.extend(data, this._serializeAdditionalData);
                }

                return data;
            }
        })

    }
)