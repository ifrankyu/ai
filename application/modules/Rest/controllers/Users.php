<?php
class UsersController extends Yaf_Controller_Abstract
{
    /**
     * Controller的init方法会被自动首先调用
     */
    public function init()
    {
        Yaf_Dispatcher::getInstance()->disableView();
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
        sleep(3);
        $page = $this->getRequest()->getQuery('page');
        // echo $page;
        $userModel = new UserModel();
        $result    = $userModel->getAll($userModel->table);
        if (is_array($result) && count($result) > 0) {
            foreach ($result as &$value) {
                $value['id'] = uniqid();
            }
        }
        $this->handleReponse('ok', 200, $result);
    }

    public function getAction()
    {
        $params    = $this->getRequest()->getParams();
        $userModel = new UserModel();
        $result    = $userModel->getOne($userModel->table, $params);
        // print_r($result);
        $this->handleReponse('ok', 200, $result);
    }

    public function postAction()
    {
        // print_r($_POST);
        $userModel = new UserModel();
        $effectRow = $userModel->insert($userModel->table, $_POST);
        var_dump($effectRow);
        // exit();
    }

    public function deleteAction()
    {
        print_r($_POST);
        // exit();
    }
}
