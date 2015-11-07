this.Ninja.module('$mediaQuery', [

  '$dispatcher'

], function ($dispatcher) {

  canProccess = [
    {
      can: function(value){ return value <= 479; },
      process: function(){ $dispatcher.trigger('resize:xs', 'resize:xs'); }
    },
    {
      can: function(value){ return value > 479 &&value <= 753; },
      process: function(){ $dispatcher.trigger('resize:sm', 'resize:sm'); }
    },
    {
      can: function(value){ return value > 753 && value <= 969; },
      process: function(){ $dispatcher.trigger('resize:md', 'resize:md'); }
    },
    {
      can: function(value){ return value > 969 && value <= 1223; },
      process: function(){ $dispatcher.trigger('resize:lg', 'resize:lg'); }
    },
    {
      can: function(value){ return value > 1223; },
      process: function(){ $dispatcher.trigger('resize:xl', 'resize:xl'); }
    }
  ];

  function storage(description){
    sessionStorage.setItem('resize', description);
  }
  

  function actualSize() {
    mainWidth = (document.body || {clientWidth: 0}).clientWidth;
    
    canProccess.forEach(function(item){
      item.can(mainWidth) && item.process();
    });
    

  }

  function attach() {

    $dispatcher.on('resize:xs', storage, this);
    $dispatcher.on('resize:sm', storage, this);
    $dispatcher.on('resize:md', storage, this);
    $dispatcher.on('resize:lg', storage, this);
    $dispatcher.on('resize:xl', storage, this);

    actualSize();

    window.matchMedia("(min-width : 320px)").addListener(actualSize);
    window.matchMedia("(min-width : 480px)").addListener(actualSize);
    window.matchMedia("(min-width : 754px)").addListener(actualSize);
    window.matchMedia("(min-width : 970px)").addListener(actualSize);
    window.matchMedia("(min-width : 1224px)").addListener(actualSize);
  }

  return {
    attach: attach
  };
  
});