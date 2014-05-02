define(
    [
        'marionette',
        'tpl!./dashboard.tpl.html',
        'i18n!./../nls/general'
    ],
    function (Marionette, TPL_Dashboard, i18n) {

        return Marionette.ItemView.extend({
            template: TPL_Dashboard,
            _serializeAdditionalData: {
                i18n: i18n.dashboard
            }
        });

    }
)