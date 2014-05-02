define(
    ['bicycle', 'helpers', 'application', 'i18n!./nls/general'],
    function (Bicycle, Helpers, App, i18n) {

        var model = {

            defaults: {
                title: i18n.newSpec
            },

            __init: function(){
                var _this = this;
                this.registerView('show', function(){
                    return new (Helpers.View.Model.Show)({
                        model:_this,

                        exclude: ["id"],
                        translations: i18n
                    });
                });

                this.registerView('edit', function(){
                    var view = new (Helpers.View.Model.Edit)({
                        model:_this,

                        exclude: ["id"],
                        translations: i18n,

                        callbacks: {
                            saved: function(){
                                App.router.navigate(_this.linkTo('show'),true);
                            }
                        }
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })

                this.registerView('new', function(){
                    var view = new (Helpers.View.Model.New)({
                        model:_this,

                        exclude: ["id"],
                        translations: i18n,

                        callbacks: {
                            saved: function(){
                                App.router.navigate(_this.linkTo('show'),true);
                            }
                        }
                    });

                    view.on('render', function(){
                        view.delegateEvents();
                    })
                    return view;
                })
            },

            toString: function(){
                return this.get('title');
            },

            shortTitle: function(){
                var titles = {};
                titles[i18n.specs.php] = "PHP";
                titles[i18n.specs.analyst] = "А";
                titles[i18n.specs.frontend] = "HTML";
                titles[i18n.specs.qa] = "QA";
                titles[i18n.specs.psd] = "PSD";
                titles[i18n.specs.js] = "JS";
                titles[i18n.specs.ios] = "iOS";
                titles[i18n.specs.android] = "And";
                titles[i18n.specs.win] = "Win";
                titles[i18n.specs.dotnet] = ".NET";
                titles[i18n.specs.java] = "JAVA";
                titles[i18n.specs.pm] = "PM";
                titles[i18n.specs.admin] = "ADMIN";
                titles[i18n.specs.officeManager] = "OFFICE";
                titles[i18n.specs.boss] = "BOSS";

                return titles[this.get('title')]?titles[this.get('title')]:this.get('title');
            },

            abbr: function(){
                var titles = {};
                titles[i18n.specs.php] = "php";
                titles[i18n.specs.analyst] = "analytics";
                titles[i18n.specs.frontend] = "html";
                titles[i18n.specs.qa] = "qa";
                titles[i18n.specs.psd] = "psd";
                titles[i18n.specs.js] = "js";
                titles[i18n.specs.dotnet] = "dotnet";

                return titles[this.get('title')]?titles[this.get('title')]:'free';
            },

            linkTo: function(type){
                var links = {
                    "new": 'admin/occupations/new',
                    "show": 'admin/occupations/'+this.id,
                    "edit": 'admin/occupations/'+this.id+'/edit'
                }
                return links[type];
            }
        };

        return Bicycle.Core.Model.extend(model);
    }
)