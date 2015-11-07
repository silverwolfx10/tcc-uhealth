this.Ninja.module('$random', ['$curry'], function ($curry) {

    var random = function(start, end) {
        return Math.floor(Math.random() * end) + start;
    };

    return $curry(random);

});