define(
    [
        'bicycle',
        './model',
        'module'
    ],
    function (Bicycle, model, module) {

        var collection = {
            model: model,
            url: module.config().url,

            getLink: function(type){
                var links = {
                    'new': 'admin/occupations/new'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)