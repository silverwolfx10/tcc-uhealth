/**
 * $render
 *
 * Um facade para atribuir um template na propriedade innerHTML de um elemento,
 * retornando um promisse a funcao curry
 *
 * @module $render
 * @author Cleber de Moraes Goncalves <cleber.programmer>
 * @example
 *
 *      $render(element, {}, './template/example.html');
 *
 */
this.Ninja.module('$myRender', [

  '$always',
  '$compose',
  '$curry',
  '$fileRequest',
  '$myInnerHTML',
  '$promisse',
  '$template'

], function ($always, $compose, $curry, $fileRequest, $myInnerHTML, $promisse, $template, _) {

  /**
   * Um facade para atribuir um template na propriedade innerHTML de um elemento,
   * retornando um promisse
   *
   * @public
   * @method render
   * @param {Node} element Elemento que recebera o template
   * @param {Object} data Dados que seram renderizado pelo template
   * @param {String} url Endereco que esta o arquivo de template
   * @param {Function} Funcao com o metodo estatico promisse
   * @example
   *
   *        $render(element, {}, './template/example.html');
   *
   */
  function render(element, data, url) {

    /**
     * Realiza toda as estruturas de execucoes de funcoes para realizar a execucao
     * do template apos o request do arquivo, retornando um promisse
     */
    function solve(resolve) {
      return resolve(setTimeout(function () {
        $fileRequest(url, $compose(resolve(), $compose($myInnerHTML(element), $template(_, data))));
      }));
    }
    
    /**
     * Retorna o promisse
     */
    return solve($always($promisse()));

  }

  /**
   * Revelacao do modulo $render, encapsulando a visibilidade das funcoes
   * privadas
   */
  return $curry(render);

});