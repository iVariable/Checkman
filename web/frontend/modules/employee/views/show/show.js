define(
    [
        'bicycle',
        'tpl!./show.tpl.html',
        'tpl!./project-history.tpl.html',
        './../../history-collection',
        'application'
    ],
    function (Bicycle, TPL_Show, TPL_ProjectHistory, ProjectHistory, App) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,

            projectHistory: null,

            onRender: function(){
                var _this = this;
                this.projectHistory = new ProjectHistory();
                this.projectHistory.setId(this.model.id);

                App.loader('Загрузка истории проектов', this.projectHistory.fetch()).done(function () {
                    _this.renderProjectHistory();
                });
            },

            renderProjectHistory: function(){
                this.$('.a-asyncreports').html(TPL_ProjectHistory({view: this, app: App, report: this.projectHistory}));
            }
        });

    }
)