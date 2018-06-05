<?php
class UserController extends Yaf_Controller_Abstract
{
    /**
     * Controller的init方法会被自动首先调用
     */
    public function init()
    {
        /**
         * 如果是Ajax请求, 则关闭HTML输出
         */
        if ($this->getRequest()->isXmlHttpRequest()) {
            Yaf_Dispatcher::getInstance()->disableView();
        }
    }

    private function handleReponse($msg, $code = 200, $data = [])
    {
        exit(json_encode([
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
        ]));

    }

    public function indexAction()
    {
        //默认Action
        exit('Hello World');

        // $this->getView()->assign('content', 'Hello World');
    }

    public function loginAction()
    {
        sleep(3);
        $raw             = $this->getRequest()->getRaw();
        $params          = json_decode($raw, true);
        $params['phone'] = str_replace(' ', '', $params['account']);
        unset($params['account']);
        if (empty($params['phone']) || empty($params['passwd'])) {

        }

        $userModel = new UserModel();
        $result    = $userModel->getOne($userModel->table, $params);

        exit(json_encode([
            'status' => $result && isset($result['id']) && $result['id'],
            'msg'    => 'ok',
            'data'   => $result,
        ]));
    }

    private function initUser($params)
    {
        $params['logo'] = empty($params['logo']) ? 'https://res.wx.qq.com/a/wx_fed/webwx/res/static/img/2KriyDK.png' : $params['logo'];

        return $params;
    }
    public function registerAction()
    {
        // sleep(3);
        try {
            $raw             = $this->getRequest()->getRaw();
            $params          = json_decode($raw, true);
            $params['phone'] = str_replace(' ', '', $params['account']);
            unset($params['account']);
            unset($params['smscode']);
            unset($params['type']);

            if (empty($params['phone']) || empty($params['passwd'])) {

            }

            $params    = $this->initUser($params);
            $userModel = new UserModel();
            $iResult   = $userModel->insert($userModel->table, $params);
            if (!$iResult) {
                throw new Exception('额，服务器开小差了，请稍后再试^_^.', 501);
            }

            $result = $userModel->getOne($userModel->table, ['phone' => $params['phone']]);
            if (!$result || !isset($result['id'])) {
                throw new Exception('额，服务器开小差了，请稍后再试^_^.', 502);
            }
            $this->handleReponse('ok', 200, $result);
        } catch (Exception $e) {
            $this->handleReponse($e->getMessage(), $e->getCode());
            return;
        }
    }

    public function sendSmsAction()
    {
        sleep(2);
        $raw             = $this->getRequest()->getRaw();
        $params          = json_decode($raw, true);
        $params['phone'] = $params['account'];
        if (empty($params['phone'])) {

        }

        // $userModel = new UserModel();
        // $iResult   = $userModel->insert($userModel->table, $params);
        // if (!$iResult) {
        //     throw new Exception('额，服务器开小差了，请稍后再试^_^.', 501);
        // }

        // $result = $userModel->getOne($userModel->table, ['phone' => $params['phone']]);
        // if (!$result || !isset($result['id'])) {
        //     throw new Exception('额，服务器开小差了，请稍后再试^_^.', 502);
        // }
        $this->handleReponse('ok', 200);
    }
}
