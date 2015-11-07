this.Ninja([

    '$curry',
    '$dispatcher',
    '$formSerialization',
    '$http',
    '$history',
    '$myRender',
    '$myWebComponent',
    '$oneOff',
    '$random',
    '$validator'


], function ($curry, $dispatcher, $formSerialization, $http, $history, $myRender, $myWebComponent, $oneOff,  $random, $validator, _) {

    var stub = {
        step: 'one',
        random: $random(1, 3),
        messages: ''
    };

    function isValid(element){
        var email = element.querySelector("#email");
        var password = element.querySelector("#password");

        stub.messages = '';

        if(email.value.trim().length <= 2 || !$validator.email(email.value.trim())){
            stub.messages += 'Email invalido<br />';
        }

        if(password.value.trim().length < 6){
            stub.messages += 'Senha invalida, minimo de 6 caracteres<br />';
        }
        stub.messages && element.querySelector('x-messages').rewind(stub.messages);

        return !stub.messages;
    }

    function send(element){

        var data = {
            email: element.querySelector("#email").value,
            password: element.querySelector("#password").value
        };

        $http('POST', $oneOff.base_url.www + '/api/authorization/login', $formSerialization(data)).when(401, function (xhr) {

            stub.messages = '';
            var response = JSON.parse(xhr.response);
            response.messages.forEach(function(item){
                stub.messages += item + '<br />';
            });

            stub.messages && element.querySelector('x-messages').rewind(stub.messages);

        }).when(200, function(xhr){
            var response = JSON.parse(xhr.response);
            location.href = response.data.redirect;
        });
    }

    $myWebComponent('x-login', {

    created: function (element) {
        element.setState(stub);
    },
    events: {
        'click .login_cadastro_action': function(){
            $history({ controller: 'cadastro' }, 'Criar uma conta', '/cadastro', true);
        },
        'click .button_login_action': function(element){
            isValid(element) && send(element);
        }
    },
    template: $myRender(_, _, $oneOff.base_url.www + $oneOff.xlogin.templateUrl)

    });


});