define(['./model'], function(model){

    var merge = function(to, from, depth) {
        if( typeof to == 'undefined' ) to = {};
        if (_.isArray(from) || _.isObject(from)){
            if (!_.isUndefined(depth) && (depth > 0)) {
                for (var key in from) {
                    if (_.isArray(from[key]) || _.isObject(from[key])){
                        to[key] = merge(to[key], from[key], depth-1);
                    }else{
                        var result = from[key];
                        if (!from[key] || (typeof from[key] !== 'object')) result = from[key]; // by value
                        else if (_.isString(from[key])) result = String.prototype.slice.call(from[key]);
                        else if (_.isDate(from[key])) result = new Date(from[key].valueOf());
                        else if (_.isFunction(from[key].clone)) result =  from[key].clone();

                        to[key] = result;
                    }
                }
            }
        }
        return to;
    };

    var setLinks = function(menu, parent){
        _(menu).each(function(item, key){
            item.parent = parent;
            item.key = key;
            if( !_.isUndefined(item.children) ){
                setLinks(item.children, item);
            }
        });
        return menu;
    }

    var buildPaths = function(menu, prefix){
        var result = {};
        _(menu).each(function(item, key){
            if( _.isUndefined(prefix) ){
                result[key] = key;
            }else{
                result[key] = prefix+'/'+key;
            }
            if( !_.isUndefined(item.children) ){
                var childrenPaths = buildPaths(item.children, result[key]);
                _.extend(result, childrenPaths);
            }
        });
        return result;
    };

    var menu = {

        __init: function(args){
            this._menu = {};
            this._breadcrumbs = [];
            this._paths = {};
            this.menu('', args);
            this._init();
        },

        _init: function(){},

        /**
         * menu = {
         *      name: '',
         *      link: '',
         *      type: '', //divider, header
         *      children: {}
         * }
         */
        _menu: undefined,

        menu: function(name, menu){

            if( typeof name != 'string' ) name = '';
            var parts = name.split('/'),
                parent = this._menu,
                pl, i;
            pl = parts.length;
            if(name.length > 0){
                for (i = 0; i < pl; i++) {
                    if (typeof parent[parts[i]] == 'undefined') {
                        parent[parts[i]] = { name: '', link: '', children: {} };
                    }
                    if( i != pl-1 ){
                        parent = parent[parts[i]].children;
                    }else{
                        parent = parent[parts[i]];
                    }
                }
            }
            if(menu){
                if( typeof menu == 'function'){
                    menu = menu(
                        parent,
                        this
                    );
                }
                parent = merge(parent, menu, 30);

                setLinks(this.menu());
                this._paths = buildPaths(this.menu());
            }
            return parent;
        },

        _selected: '',
        selected: function(selected){
            if( typeof selected != 'undefined' ){
                this._selected = selected
                //Setting breadcrumbs
                var path = [];
                this._breadcrumbs = [];
                _(this.selectedKeys()).each(function(key){
                    path.push(key);
                    var item = this.menu(path.join('/'));
                    if( !item ) return;
                    this._breadcrumbs.push(item);
                }, this);
            };
            return this._selected;
        },

        selectedKeys: function(){
            return this.selected().split('/');
        },

        selectedKey: function(key){
            this.selected(this._paths[key]);
        },

        _breadcrumbs: '',
        breadcrumbs: function(set){
            if(!_.isUndefined(set)) this._breadcrumbs = set;
            return this._breadcrumbs;
        },
        addBreadcrumb: function(crumb){
            this._breadcrumbs.push(crumb);
            return this;
        }

    };
    return model.extend(menu);
});