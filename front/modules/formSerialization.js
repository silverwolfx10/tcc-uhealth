this.Ninja.module('$formSerialization', [], function () {

    var serializer = function(object) {
       var data = '';

        Object.keys(object).forEach(function(item){
            data += data ? ('&' + item + '=' + object[item]) : (item + '=' + object[item]);
        });

        return data;
    }

    return serializer;

});