define(
    [
        'marionette',
        'tpl!./dashboard.tpl.html'
    ],
    function (Marionette, TPL_Dashboard) {

        return Marionette.ItemView.extend({
            template: TPL_Dashboard
        });

    }
)