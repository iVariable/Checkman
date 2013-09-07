define(
    [
        'bicycle',
        'tpl!./list.tpl.html'
    ],
    function (Bicycle, TPL_List) {

        return Bicycle.Core.View.extend({
            template: TPL_List,

            onRender: function(){
                setTimeout(function(){
                    $(".m-rotate-270").each(function(){
                        $(this).height($(this).width());
                    })
                }, 1000);

            }
        });

    }
)