this.Ninja([

    '$oneOff',
    '$pick',
    '$myRender',
    '$myWebComponent'

], function ($oneOff, $pick, $myRender, $myWebComponent, _) {

    $myWebComponent('x-social', {

        created: function (element) {
            element.setState($pick(['type'], element));
        },

        events: {
            'click .button_linkedin_action': function(){
                location.href = $oneOff.base_url.api + "/v1/login?type=linkedin&redirect=http://www.uhealth.com.br/api/authorization";
            },
            'click .button_facebook_action': function(){
                location.href = $oneOff.base_url.api + "/v1/login?type=facebook&redirect=http://www.uhealth.com.br/api/authorization";
            },
            'click .button_twitter_action': function(){
                location.href = $oneOff.base_url.api + "/v1/login?type=twitter&redirect=http://www.uhealth.com.br/api/authorization";
            }

        },

        template: $myRender(_, _, $oneOff.base_url.www + $oneOff.xsocial.templateUrl)

    });

});