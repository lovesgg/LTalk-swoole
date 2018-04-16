<?php
/**
 * Created by PhpStorm.
 * User: yuzhang
 * Date: 2018/4/14
 * Time: 下午5:08
 */

namespace App\WebsocketController;


use App\Service\UserCacheService;

class OnOpen extends BaseWs
{
    /*
     * 用户连线后初始化
     * 传参：token
     * 1. 获取用户 fd
     * 2. 初始化所有相关缓存
     * 3. 向所有好友发送上线提醒
     * 4. 向所有群聊发送上线提醒
     */
    public function init(){
        $user = $this->getUserInfo();

        //初始化所有相关缓存
        $this->saveCache($user);

        // 查出所有好友，查所有好友的在线状态，向所有好友发送异步上线提醒
        $this->sendOnlineMsg();
        $this->sendMsg();
    }

    private function saveCache($user){
        // 更新用户在线状态缓存（ 添加 fd 字段 ）
        UserCacheService::saveNumToFd($user['user']['number'], $user['fd']);

        // 添加 fd 与 token 关联缓存，close 时可以销毁 fd 相关缓存
        UserCacheService::saveTokenByFd($user['fd'], $user['token']);
    }

    private function sendOnlineMsg(){

    }
}