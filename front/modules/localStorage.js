this.Ninja.module('$localStorage', [], function () {

    var set = function(name, obj){
        localStorage.setItem(name, JSON.stringify(obj));
    };
    var get = function(name){
        return JSON.parse(localStorage.getItem(name));
    };
    var clear = function(){
        returnlocalStorage.clear();
    };

    return {
        set: set,
        get: get,
        clear: clear
    };

});