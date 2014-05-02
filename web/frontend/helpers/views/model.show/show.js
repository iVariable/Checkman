define(
    [
        'bicycle',
        'tpl!./show.tpl.html',
        'i18n!nls/general'
    ],
    function (Bicycle, TPL_Show, i18n) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,
            _serializeAdditionalData: {
                i18n: i18n
            }
        });

    }
)