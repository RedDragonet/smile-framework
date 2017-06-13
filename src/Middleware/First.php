<?php
namespace Smile\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Smile\Interfaces\IMiddleware;
use Closure;

class First implements IMiddleware{

    public static function handle(ServerRequestInterface $request,Closure $next)
    {
        //打印request 可以进行相关操作
        var_dump($request);
        return $next($request);
    }
}