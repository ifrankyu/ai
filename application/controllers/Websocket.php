<?php
class WebsocketController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        $server = new swoole_websocket_server('0.0.0.0', 9501);

        $server->on('open', function (swoole_websocket_server $server, $request) {
            $redis       = Yaf_Registry::get('redis');
            $onlineCount = $redis->get('onlineCount');
            $redis->set('onlineCount', $onlineCount + 1);
            print_r($request);
        });

        $server->on('message', function (swoole_websocket_server $server, $frame) {
            $redis = Yaf_Registry::get('redis');
            $redis->lPush('chatlist' . $frame->fd, $frame->data);
            echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
            $server->push($frame->fd, 'this is serversss');
        });

        $server->on('close', function ($ser, $fd) {
            $redis       = Yaf_Registry::get('redis');
            $onlineCount = $redis->get('onlineCount');
            $redis->set('onlineCount', $onlineCount - 1);
            echo "client {$fd} closed\n";
        });

        $server->start();
    }
}
