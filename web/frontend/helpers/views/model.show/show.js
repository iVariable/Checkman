define(
    [
        'bicycle',
        'tpl!./show.tpl.html'
    ],
    function (Bicycle, TPL_Show) {

        return Bicycle.Core.View.extend({
            template: TPL_Show
        });

    }
)