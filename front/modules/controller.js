this.Ninja.module('$controller', [], function () {

    var controller = (document.querySelector('#controller') || { value: 'home' }).value;
    var action = (document.querySelector('#action') || { value: 'home' }).value;
    var url = (document.querySelector('#url') || { value: '/' }).value;
    var title = (document.querySelector('#title') || { value: 'uHealth' }).value;

    return {
        controller: controller,
        action: action,
        url: url,
        title: title
    };

});