<?php
namespace Smile\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Smile\Interfaces\IMiddleware;
use Closure;

class Second implements IMiddleware{

    public static function handle(ServerRequestInterface $request,Closure $next)
    {
        //打印request 可以进行相关操作
        echo "我是第二个中间件".PHP_EOL;
        return $next($request);
    }
}