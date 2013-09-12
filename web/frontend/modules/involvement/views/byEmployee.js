define(
    [
        'bicycle',
        'tpl!./byEmployee.tpl.html'
    ],
    function (Bicycle, TPL_List) {

        return Bicycle.Core.View.extend({
            template: TPL_List
        });

    }
)