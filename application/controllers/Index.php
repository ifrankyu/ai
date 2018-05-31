<?php
class IndexController extends Yaf_Controller_Abstract
{
    /**
     * Controller的init方法会被自动首先调用
     */
    // public function init()
    // {
    //     /**
    //      * 如果是Ajax请求, 则关闭HTML输出
    //      */
    //     if ($this->getRequest()->isXmlHttpRequest()) {
    //         Yaf_Dispatcher::getInstance()->disableView();
    //     }
    // }

    public function indexAction()
    {
        //默认Action
        exit('Hello World');

        // $this->getView()->assign('content', 'Hello World');
    }

    public function websocketAction()
    {
        $server = new swoole_websocket_server('0.0.0.0', 9501);

        $server->on('open', function (swoole_websocket_server $server, $request) {
            echo "server: handshake success with fd{$request->fd}\n";
        });

        $server->on('message', function (swoole_websocket_server $server, $frame) {
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $server->push($frame->fd, 'this is server');
        });

        $server->on('close', function ($ser, $fd) {
            echo "client {$fd} closed\n";
        });

        $server->start();
    }

    public function getAction()
    {
        //默认Action
        exit('Hello get');

        // $this->getView()->assign('content', 'Hello World');
    }
}
