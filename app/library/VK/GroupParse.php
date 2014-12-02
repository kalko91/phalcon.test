<?php

class groupParse {
    protected $groupId;
    protected $offset = 0;
    protected $count = 100;
    protected $vk;

    protected $apiKey = '4657346';
    protected $secretKey = 'XcskYhqOJ0IPwmeGo8F1';
    protected $token = '2dc1ee775f49465a6d7c463d9e6f783c5a13096839175a4692558f230d2bbd76568b1783432fb78b736a0';

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param mixed $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
    }

    /**
     * @return mixed
     */
    public function getVk()
    {
        return $this->vk;
    }

    /**
     * @param mixed $vk
     */
    public function setVk($vk)
    {
        $this->vk = $vk;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount($count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    public function setOffset($offset)
    {
        $this->offset = $offset;
    }



    public function __construct($groupId){
        $this->setGroupId($groupId);
        $this->setVk(new VK\VK($this->apiKey,$this->secretKey));
    }

    public function get(){
        return $this->getVk()->api('wall.get', array(
            'owner_id'=>'-23537466',
            'count'=>$this->getCount(),
            'offset'=>$this->getOffset(),
        ));
    }

    public function getNext(){
        $this->setOffset($this->getCount());
        return $this->get();
    }


}