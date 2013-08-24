define(
    [
        'marionette',
        'tpl!./listRoutes.tpl.html'
    ],
    function (Marionette, TPL_Routes) {

        return Marionette.ItemView.extend({
            template: TPL_Routes
        });

    }
)