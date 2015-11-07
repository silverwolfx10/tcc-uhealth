this.Ninja.module('$noAccents', [], function () {

    function noAccents(str)
    {
        str = str || '';
        str = str.replace(/[ÀÁÂÃÄÅ]/,"A");
        str = str.replace(/[àáâãäå]/,"a");
        str = str.replace(/[ÈÉÊË]/,"E");
        str = str.replace(/[Ç]/,"C");
        str = str.replace(/[ç]/,"c");

        return str;
    }

  return noAccents;

});