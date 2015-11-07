this.Ninja.module('$ternary', ['$curry'], function ($curry) {

  var ternary = function(condition, then, otherwise) {
  	return condition ? then : otherwise;
  };

  return $curry(ternary);

});