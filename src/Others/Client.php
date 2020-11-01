<?php
namespace AppYMBL\Others;

use AppYMBL\Others\ParseConfig;
use Exception;
use Symfony\Component\DependencyInjection\Parameter;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class Client
{
    private $client;

    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    public function request(String $requestName){
        $data = ParseConfig::myParser();
        $getInformationByKeyName = $data[$requestName];
        if(is_null($getInformationByKeyName))
            return JsonResponse::create(["error - this key does not exist"]);
        $option = $parameters = $headers =  Array();
        foreach($getInformationByKeyName as $baseKey => $baseValue){
            switch ($baseKey) {
                case 'headers':
                    if(is_array($baseValue))
                        foreach($baseValue as $key => $value)
                            $option[$baseKey][$key] = $value;
                    break;
                case 'parameters':
                    if(is_array($baseValue))
                        foreach($baseValue as $key => $value)
                            $option[$key] = $value;
                    break;
                default:
                    if('url' != $baseKey && 'method' != $baseKey)
                        $option[$baseKey] = $baseValue;
                break;
            }
        }
        try {
            $client = $this->client->request($getInformationByKeyName['method'], $getInformationByKeyName['url'], $option);
            return $this->response($client);
        } catch (Exception $exception) {
            return [
                'hasError' => true,
                'statusCode' => $exception->getCode(),
                'message' => $exception->getMessage()
            ];
        }
    }

    public function response(Object $objet){
        $content = $objet->getContent(false);
        $statusCode = $objet->getStatusCode();
        $headers['haseError'] = true;
        $headers['statusCode'] = $statusCode;
        if($statusCode >= 200 && $statusCode <= 209){
            $headers['hasError'] = false;
            $items['items'] = $content;
        }else{
            $items['message'] = $content;
        }
        return [$headers, $items]; 
    }

    public static function dd($var){
        var_dump($var);die;
    }
}