define(
    [
        'bicycle',
        './model',
        'helpers',
        'backbone_actas_paginatable',
        'module'
    ],
    function (Bicycle, model, Helpers, Paginatable, module) {

        var collection = {
            model: model,
            urlRoot: module.config().url,
            modelUrlRoot: module.config().url
        }

        collection = Bicycle.Core.Collection.extend(collection);

        Paginatable.init(collection, model);

        return collection;
    }
)