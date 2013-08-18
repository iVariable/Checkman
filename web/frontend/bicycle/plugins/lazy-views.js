define(function(){

    var lazyView = {

        _views: undefined,
        _viewCreators: undefined,

        registerView: function(name, view){
            this._views = this._views || {};
            this._viewCreators = this._viewCreators || {};
            if( typeof view != 'function' ){
                var viewCreator = function(){
                    return view;
                }
            }else{
                var viewCreator = view;
            }
            this._views[name] = _.once(viewCreator);
            this._viewCreators[name] = viewCreator;
        },

        unregisterView: function(name){
            this._views = this._views || {};
            delete this._views[name];
        },

        hasView: function(name){
            this._views = this._views || {};
            return !_.isUndefined(this._views[name]);
        },

        detachedView: function(name){
            if( this.hasView(name) ){
                return this._viewCreators[name]();
            }
            if( typeof console != 'undefined' ) console.log('View not found!', this._views, name);
            throw Error('View not found ['+name+']!');
        },

        view: function(name){
            if( this.hasView(name) ){
                return this._views[name]();
            }
            if( typeof console != 'undefined' ) console.log('View not found!', this._views, name);
            throw Error('View not found ['+name+']!');
        }
    }

    return lazyView;
});