/**
 * $innerHTML
 *
 * Um facade para a atribuicao da propriedade innerHTML do shadowRoot
 * de um webComponent espedifico a funcao curry
 *
 * @module $innerHTML
 * @author Cleber de Moraes Goncalves <cleber.programmer>
 * @example
 *
 *        $innerHTML(element, '<p>Hi cleber.programmer</p>');
 *
 */
this.Ninja.module('$myInnerHTML', ['$curry'], function ($curry) {

  /**
   * Um facade para a atribuicao da propriedade innerHTML do shodowRoot de
   * um elemento webComponent
   *
   * @public
   * @method innerHTML
   * @param {Node} element WebComponent que sera manipulado
   * @param {String} html Compo do webComponent em formato literal de caracteres
   * @example
   *
   *        $innerHTML(element, '<p>Hi cleber.programmer</p>');
   *
   */
  function innerHTML(element, html) {
    element.innerHTML = html;
  }

  /**
   * Revelacao do modulo $innerHTML, encapsulando a visibilidade das funcoes
   * privadas
   */
  return $curry(innerHTML);

});
