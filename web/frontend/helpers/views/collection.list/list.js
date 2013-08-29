define(
    [
        'marionette',
        'tpl!./list.tpl.html'
    ],
    function (Marionette, TPL_List) {


        return Marionette.ItemView.extend({
            template: TPL_List,

            events: {
                'click .j-new-occupation': "event_newModel",
                'click .j-edit-occupation': "event_editModel",
                'click .j-remove-occupation': "event_removeModel"
            },

            event_newModel: function(){},
            event_editModel: function(){},
            event_removeModel: function(){}

        });

    }
)