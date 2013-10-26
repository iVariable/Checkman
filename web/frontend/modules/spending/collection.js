define(
    [
        'bicycle',
        './model',
        'helpers',
        'module'
    ],
    function (Bicycle, model, Helpers, module) {

        var collection = {
            model: model,
            url: module.config().url
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)