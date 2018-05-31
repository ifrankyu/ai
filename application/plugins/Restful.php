<?php
class RestfulPlugin extends Yaf_Plugin_Abstract
{
    private static $methodTypes = ['GET', 'POST', 'PUT', 'DELETE'];
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        if (!in_array($request->method, self::$methodTypes)) {
            exit('ok');
        }

        // print_r($request);
        if ('Index' === $request->module && 'Rest' === $request->controller) {
            $request->module     = 'Rest';
            $request->controller = $request->action;
            $request->action     = 'GET' === $request->method ? 'index' : $request->method;
        }

        if ($request->module !== 'Rest') {
            return;
        }

        if (preg_match('/\d+/', $request->action)) {
            $request->setParam('id', $request->action);
            $request->action = $request->method;
        }
    }
}
