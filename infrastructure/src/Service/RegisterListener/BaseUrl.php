<?php

namespace Infra\RegisterListeners;

/**
 *
 * Registra o serviço de CDN
 *
 * @package Infra
 * @author Leandro Menezes
 *
 **/
class RegisterBaseUrlListener
{
    /**
     * Inicializa os serviços de CDN
     *
     * @param $di
     * Dependence Injetion Manager do Phalcon
     *
     *
     * @param $extension
     * Extensão do arquivo que sobrescreve as configurações com extensão .global
     * no caso de testes passamos o parametro como 'test', possibilidades atuais ('local', 'test', 'global')
     */
    public static function init(\Phalcon\DI $di,  $extension = 'local')
    {

        //se estiver rodando testes
        if($extension == 'test'){
            if(!file_exists(__DIR__ . '/../config/base_url.test.php')){
                throw new \Exception("Arquivo base_url.test.php nao existe");
                
            }
        }
        //verifica configuracoes locais
        $config = include file_exists(__DIR__.'/../config/base_url.'.$extension.'.php')? __DIR__.'/../config/base_url.'.$extension.'.php' : __DIR__.'/../config/base_url.global.php';

        if (isset($config['base_url']) && $config['base_url']) {

            foreach ($config['base_url'] as $k => $base_url) {
                $name = 'base_url_' . $k;

                //adiciona as configurações de CDN
                $di->set($name, function () use ($base_url) {
                    return $base_url;
                });
            }
        }
    }
}
