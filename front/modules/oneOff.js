this.Ninja.module('$oneOff', [], function () {

  return {
        'base_url': "<inject:base_url>",
        'xbody': {
          templateUrl: '/front/templates/x-body.html'
        },
        'xcadastro': {
          templateUrl: '/front/pages/x-cadastro.html'
        },
        'xconta': {
          templateUrl: '/front/templates/x-conta.html'
        },
        'xcontainertag': {
          templateUrl: '/front/templates/x-containertag.html'
        },
        'xdepoimentos': {
          templateUrl: '/front/templates/x-depoimentos.html'
        },
        'xhome': {
          templateUrl: '/front/pages/x-home.html'
        },
        'xlist': {
          templateUrl: '/front/pages/x-list.html'
        },
        'xlisting': {
          templateUrl: '/front/templates/x-listing.html'
        },
        'xloading': {
          templateUrl: '/front/templates/x-loading.html'
        },
        'xlogin': {
          templateUrl: '/front/pages/x-login.html'
        },
        'xmapa': {
          templateUrl: '/front/pages/x-mapa.html'
        },
        'xmenu': {
            templateUrl: '/front/templates/x-menu.html'
        },
        'xmeuanuncio': {
            templateUrl: '/front/templates/x-meuanuncio.html',
            availables: [
                {
                    active: false,
                    value: 'sunday',
                    text: 'domingo'
                },
                {
                    active: false,
                    value: 'monday',
                    text: 'segunda'
                },
                {
                    active: false,
                    value: 'tuesday',
                    text: 'terça'
                },
                {
                    active: false,
                    value: 'wednesday',
                    text: 'quarta'
                },
                {
                    active: false,
                    value: 'thursday',
                    text: 'quinta'
                },
                {
                    active: false,
                    value: 'friday',
                    text: 'sexta'
                },
                {
                    active: false,
                    value: 'saturday',
                    text: 'sabado'
                }
            ],
            status: [
                {
                    value: 'draft',
                    text: 'Rascunho'
                },
                {
                    value: 'published',
                    text: 'Publicado'
                },
                {
                    value: 'unpublished',
                    text: 'Despublicado'
                },
                {
                    value: 'waiting for approval',
                    text: 'Aguardando aprovação do CREF'
                }
            ],
            hour_range: [
                {
                  value:0,
                  text:'00:00'
                },
                {
                  value:1,
                  text:'01:00'
                },
                {
                  value:2,
                  text:'02:00'
                },
                {
                  value:3,
                  text:'03:00'
                },
                {
                  value:4,
                  text:'04:00'
                },
                {
                  value:5,
                  text:'05:00'
                },
                {
                  value:6,
                  text:'06:00'
                },
                {
                  value:7,
                  text:'07:00'
                },
                {
                  value:8,
                  text:'08:00'
                },
                {
                  value:9,
                  text:'09:00'
                },
                {
                  value:10,
                  text:'10:00'
                },
                {
                  value:11,
                  text:'11:00'
                },
                {
                  value:12,
                  text:'12:00'
                },
                {
                  value:13,
                  text:'13:00'
                },
                {
                  value:14,
                  text:'14:00'
                },
                {
                  value:15,
                  text:'15:00'
                },
                {
                  value:16,
                  text:'16:00'
                },
                {
                  value:17,
                  text:'17:00'
                },
                {
                  value:18,
                  text:'18:00'
                },
                {
                  value:19,
                  text:'19:00'
                },
                {
                  value:20,
                  text:'20:00'
                },
                {
                  value:21,
                  text:'21:00'
                },
                {
                  value:22,
                  text:'22:00'
                },
                {
                  value:23,
                  text:'23:00'
                }
            ]
        },
        'xmeusalunos': {
          templateUrl: '/front/templates/x-meusalunos.html'
        },
        'xmeuspacotes': {
          templateUrl: '/front/templates/x-meuspacotes.html'
        },
        'xminhascompras': {
          templateUrl: '/front/templates/x-minhascompras.html'
        },
        'xmessages': {
          templateUrl: '/front/templates/x-messages.html'
        },
        'xminhaconta': {
          templateUrl: '/front/pages/x-minhaconta.html'
        },
        'xpersonal': {
          templateUrl: '/front/pages/x-personal.html'
        },
        'xperguntasrecebidas': {
          templateUrl: '/front/templates/x-perguntasrecebidas.html'
        },
        'xrelateds': {
          templateUrl: '/front/templates/x-relateds.html'
        },
        'xsearchbar': {
          templateUrl: '/front/templates/x-searchbar.html'
        },
        'xselect': {
          templateUrl: '/front/templates/x-select.html'
        },
        'xsocial': {
          templateUrl: '/front/templates/x-social.html'
        }
     };

});