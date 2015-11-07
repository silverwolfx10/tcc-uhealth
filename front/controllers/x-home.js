this.Ninja([

    '$curry',
    '$dispatcher',
    '$event',
    '$history',
    '$http',
    '$myRender',
    '$myWebComponent',
    '$oneOff',
    '$pick',
    '$random'


], function ($curry, $dispatcher, $event, $history, $http, $myRender, $myWebComponent, $oneOff, $pick, $random, _) {

    var stub = {
        step: 'one',
        random: $random(1, 3),
        city: '',
        uf: '',
        states: [],
        cities: [],
        address: ''
    };

    var dataCep;

    function resolve(element){
        if(/two/.test(stub.step)) {
            element.querySelector("#home_state").rewind(stub.states);
            element.querySelector("#home_city").rewind(stub.cities);
        }
    }

    $myWebComponent('x-home', {

    created: function (element) {
        element.setState(stub);
    },
    events: {
        'click .button_search_home_action': function(element, e){
            stub.step = 'two';
            var cep = element.querySelector('#cep_home');

            $dispatcher.trigger('loading:open', true);

            $http('GET', $oneOff.base_url.www + '/api/address/zipcode/' + cep.value, '')
                .when(200, function (xhr) {
                    response = JSON.parse(xhr.response);

                    if(response){
                        dataCep = response.data.cep;
                        stub.city = response.data.cep.street.city_id;
                        stub.uf = response.data.cep.city.state;
                        stub.states = response.data.states;
                        stub.cities = response.data.cities;
                        stub.address = response.data.cep.street.street_type + ' ' +  response.data.cep.street.nm_street + ' - ' + response.data.cep.hood.nm_hood;
                    }

                    element.setState(stub);

                    $dispatcher.trigger('loading:close', true);

                });
        },
        'click .button_back_home_action': function(element, e){
            stub.step = 'one';
            element.setState(stub);
        },
        'click .button_search_personals_home_action': function(element){
            $dispatcher.trigger('loading:open', true);
            var number = element.querySelector('#home_number').value;

            var url = '/' + stub.uf;

            url += '/' + dataCep.city.nm_city;
            url += '/' + dataCep.hood.nm_hood;
            url += '/' + dataCep.street.complete_name;

            url = url.toLowerCase().split(' ').join('-');

            if(number) {
                url += '/' + number;
                $http('GET', $oneOff.base_url.www + '/api/address/zipcodeNumber/' + dataCep.street.zip_code, '/' + number)
                    .when(200, function (xhr) {
                        response = JSON.parse(xhr.response);

                        if (response) {
                            document.querySelector('#geographic_lat').value = dataCep.street.lat;
                            document.querySelector('#geographic_lng').value = dataCep.street.lng;
                            $history({controller: 'mapa'}, 'Buscando Personais', url, true);
                        }
                        $dispatcher.trigger('loading:close', true);
                    });
            }else{
                document.querySelector('#geographic_lat').value = dataCep.street.lat;
                document.querySelector('#geographic_lng').value = dataCep.street.lng;

                $dispatcher.trigger('loading:close', true);

                $history({controller: 'mapa'}, 'Buscando Personais', url, true);
            }
        }

    },
    template: function (element, data) {
        $myRender(element, data, $oneOff.base_url.www + $oneOff.xhome.templateUrl).done(resolve.bind(null, element));
    }

    });


});