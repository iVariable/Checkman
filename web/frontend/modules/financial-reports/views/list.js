define(
    [
        'marionette',
        'tpl!./list.tpl.html'
    ],
    function (Marionette, TPL_List) {

        return Marionette.ItemView.extend({
            template: TPL_List
        });

    }
)