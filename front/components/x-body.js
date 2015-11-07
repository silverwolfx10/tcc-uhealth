this.Ninja([

    '$curry',
    '$dispatcher',
    '$event', 
    '$oneOff',
    '$pick',
    '$myRender',
    '$myWebComponent'

], function ($curry, $dispatcher, $event, $oneOff, $pick, $myRender, $myWebComponent, _) {

    var hook = $curry(function(element, method) {

        $dispatcher[method]('pageChange', function(description){

            element.setState(description);

        }, element);
    });

    $myWebComponent('x-body', {

    attached: hook(_, 'on'),

    detached: hook(_, 'off'),

    template: $myRender(_, _, $oneOff.base_url.www + $oneOff.xbody.templateUrl)

    });

});