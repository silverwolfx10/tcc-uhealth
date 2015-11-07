this.Ninja.module('$queryString', [], function () {

  function queryString(key){
    return decodeURI((location.search.match(new RegExp('[\?\&]' + key + '=([^\&]*)(\&?)','i')) || [null, ''])[1]);
  };

  return queryString;

});