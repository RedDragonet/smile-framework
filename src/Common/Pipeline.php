<?php
namespace Smile\Common;

use Closure;

/**
 * @思想来源 laravel
 * @参考 https://segmentfault.com/a/1190000006919621#articleHeader2
 * Class Pipeline
 * @package Smile\Common
 */
class Pipeline
{
    /**
     * @var array
     */
    protected $middlewares = [];

    /**
     * @var int
     */
    protected $request;

    /**
     * 初始化第一个调用
     * 实际上由于array_reduce和闭包函数原因
     * 实际上是最后一个调用函数
     * @param Closure $destination
     * @return Closure
     */
    function getInitialSlice(Closure $destination)
    {
        return function ($passable) use ($destination) {
            return call_user_func($destination, $passable);
        };
    }

    /**
     * array_reduce循环嵌套闭包的处理行数
     * @return Closure
     */
    function getSlice()
    {
        return function ($stack, $pipe) {
            return function ($passable) use ($stack, $pipe) {
                return call_user_func_array([$pipe, 'handle'], [$passable, $stack]);
            };
        };
    }

    /**
     * 赋值request
     * @param $request
     * @return $this
     */
    function send($request)
    {
        $this->request = $request;
        return $this;
    }

    /**
     * 赋值中间件
     * @param array $middlewares
     * @return $this
     */
    function through(array $middlewares)
    {
        $this->middlewares = $middlewares;
        return $this;
    }

    /**
     * 执行操作
     * @param Closure $destination
     * @return mixed
     */
    function then(Closure $destination)
    {
        $firstSlice = $this->getInitialSlice($destination);

        $pipes = array_reverse($this->middlewares);

        $run = array_reduce($pipes, $this->getSlice(), $firstSlice);

        return call_user_func($run, $this->request);
    }
}