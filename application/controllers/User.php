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

    public function indexAction()
    {
        //默认Action
        exit('Hello World');

        // $this->getView()->assign('content', 'Hello World');
    }

    public function loginAction()
    {
        $raw = $this->getRequest()->getRaw();

        $params          = json_decode($raw, true);
        $params['phone'] = $params['account'];
        unset($params['account']);
        $userModel = new UserModel();
        $result    = $userModel->getOne($userModel->table, $params);

        exit(json_encode([
            'status' => $result && isset($result['id']) && $result['id'],
            'msg'    => 'ok',
            'data'   => $result,
        ]));
    }

    public function getAction()
    {
        //默认Action
        exit('Hello get');

        // $this->getView()->assign('content', 'Hello World');
    }
}
