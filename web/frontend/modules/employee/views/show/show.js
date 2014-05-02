define(
    [
        'bicycle',
        'tpl!./show.tpl.html',
        'tpl!./project-history.tpl.html',
        './../../history-collection',
        'i18n!./../../nls/general',
        'i18n!nls/general',
        'application'
    ],
    function (Bicycle, TPL_Show, TPL_ProjectHistory, ProjectHistory, i18n, _i18n, App) {

        return Bicycle.Core.View.extend({
            template: TPL_Show,
            _serializeAdditionalData: {
                i18n: _i18n
            },

            projectHistory: null,

            onRender: function () {
                var _this = this;
                this.projectHistory = new ProjectHistory();
                this.projectHistory.setId(this.model.id);

                App.loader(i18n.loadingProjectHistory, this.projectHistory.fetch()).done(function () {
                    _this.renderProjectHistory();
                });
            },

            renderProjectHistory: function () {
                this.$('.a-asyncreports').html(
                    TPL_ProjectHistory({view: this, app: App, report: this.projectHistory, i18n: i18n})
                );
            }
        });

    }
)