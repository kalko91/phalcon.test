<?php
class VkparseCommand extends CConsoleCommand
{
    public function actionIndex() {
        $vkgroups = VkGroup::model()->findAll();
        foreach ($vkgroups as $vkgroup) {
            echo $vkgroup->owner_id." - ".$vkgroup->name;
            $last_time = 0;
            $lastPost = Post::model()->find(array(
                'condition' => 'group_id=:group_id',
                'params'    => array(':group_id' => $vkgroup->id),
                'order'     => 'post_date DESC'
            ));
            if ($lastPost && isset($lastPost->post_date) && $lastPost->post_date != null) {
                $last_time = $lastPost->post_date;
            }
            $count =0;
            for ($i = 0; $i < 1000; $i += 100) {
                $VkPosts = Yii::app()->vk->group($vkgroup->owner_id, 100, $i)->get();
                if (isset($VkPosts['response'])) {
                    foreach ($VkPosts['response'] as $VkPost) {
                        if (!isset($VkPost['id'])) {
                            continue;
                        }
                        if ($VkPost['date'] <= $last_time) {
                            break;
                        }
                        $post_id = Post::createPost($VkPost,$vkgroup);
                        if ($post_id) {
                            if (isset($VkPost['attachments'])) {
                                foreach ($VkPost['attachments'] as $value) {
                                    $attachment = new PostAttachment();
                                    $attachment->createAttach($post_id, $value);
                                    $errors = $attachment->getErrors();
                                    if (!empty($errors)) {
                                        print_r($errors);
                                        print_r($attachment->attributes);
                                        print_r($value);
                                        exit();
                                    }
                                    $count++;
                                }
                            }
                        }
                    }
                }elseif(isset($VkPosts['error'])){
                    echo $VkPosts['error']['error_msg']."\n";
                }
            }
            echo "(".$count.")\n";
        }
        $this->parsevideo();
    }
    public function parsevideo(){
        $vkgroups = VkGroup::model()->findAll();
        foreach ($vkgroups as $vkgroup) {
            PostAttachment::parseVideo($vkgroup->id);
        }
    }
}