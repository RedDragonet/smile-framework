<?php
namespace Smile\Interfaces;

use Psr\Http\Message\ServerRequestInterface;
use Closure;
/**
 * 中间件接口
 * Interface IMiddleware
 * @package Smile\Interfaces
 */
interface IMiddleware{
    public static function handle(ServerRequestInterface $request,Closure $next);
}