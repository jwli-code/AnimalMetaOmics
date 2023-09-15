<?php

namespace app\amldb\controller;

use think\Controller;
use think\Db;

class Publicfunc extends Controller
{

    public function filterSqlInjection($input)
    {
        // 转换为小写字符
        $lowercasedInput = strtolower($input);
        // 定义一个模式数组来匹配特定的SQL注入关键字
        $patterns = [
            '/select/',
            '/ and /',
            '/ or /',
            '/-/',
            '/#/',
            '/user/',
            '/root/',
            '/password/',
            '/union/',
            '/delete/',
            '/exec/',
            '/waitfor/',
            '/delay/',
            '/xor/',
            '/rlike/',
        ];
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $lowercasedInput)) {
                return 'error';
            }
        }
        return $input;
    }
}
