define(
    [
        'marionette',
        'tpl!./show.tpl.html'
    ],
    function (Marionette, TPL_Show) {


        return Marionette.ItemView.extend({
            template: TPL_Show
        });

    }
)