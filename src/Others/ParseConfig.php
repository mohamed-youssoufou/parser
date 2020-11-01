<?php

namespace AppYMBL\Others;

use Symfony\Component\Yaml\Yaml as YamlYaml;

class ParseConfig
{
    public static function myParser()
    {
        return YamlYaml::parseFile(dirname(dirname(__FILE__)).'/config/parser.yaml');
    }
}