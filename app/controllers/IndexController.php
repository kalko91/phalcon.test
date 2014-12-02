<?php


class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $api_key = '4657346';
        $secret_key = 'XcskYhqOJ0IPwmeGo8F1';
        $token = '2dc1ee775f49465a6d7c463d9e6f783c5a13096839175a4692558f230d2bbd76568b1783432fb78b736a0';
        $vk = new VK\VK($api_key,$secret_key);
        $vk->getAuthorizeURL($secret_key, 'http://vk.com/feed'); // grt code link
        $vk->api('wall.get', array(
            'owner_id'=>'-23537466',
        ));
//        print_r($vk->getAccessToken($code)); // grt code link
//        exit();
    }



}

