define(
    [
        'bicycle',
        './model',
        'helpers',
        'i18n!./nls/general',
        'module'
    ],
    function (Bicycle, model, Helpers, i18n, module) {

        var collection = {
            model: model,
            url: module.config().url,

            __init: function(){
                var _this = this;
                this.registerView('list', function(){
                    return new (Helpers.View.Collection.List)({
                        model:_this,

                        exclude: ["id"],
                        translations: i18n.model,

                        fields: {
                            status: {
                                type: "enum",
                                values: _this.model.prototype.statuses
                            },
                            region_id: {
                                type: "entity",
                                entityType: "regions",
                                getter: "region",
                                nullable: true
                            }
                        },

                        title: i18n.projects,
                        callbacks: {
                            removed: function(){
                                _this.render();
                            }
                        }
                    });
                })
            },

            comparator: function(elem1, elem2){
                return elem1.get('title') < elem2.get('title')?-1:1;
            },

            linkTo: function(type){
                var links = {
                    'new': 'admin/projects/new',
                    'list': 'admin/projects'
                }
                return links[type];
            }
        }

        return Bicycle.Core.Collection.extend(collection);
    }
)