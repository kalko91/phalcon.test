<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class VkresourcesController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for vkresources
     */
    public function searchAction()
    {

        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "Vkresources", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "id";

        $vkresources = Vkresources::find($parameters);
        if (count($vkresources) == 0) {
            $this->flash->notice("The search did not find any vkresources");

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $vkresources,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a vkresource
     *
     * @param string $id
     */
    public function editAction($id)
    {

        if (!$this->request->isPost()) {

            $vkresource = Vkresources::findFirstByid($id);
            if (!$vkresource) {
                $this->flash->error("vkresource was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "vkresources",
                    "action" => "index"
                ));
            }

            $this->view->id = $vkresource->getId();

            $this->tag->setDefault("id", $vkresource->getId());
            $this->tag->setDefault("vk_id", $vkresource->getVkId());
            $this->tag->setDefault("status", $vkresource->getStatus());
            $this->tag->setDefault("name", $vkresource->getName());
            $this->tag->setDefault("url", $vkresource->getUrl());
            $this->tag->setDefault("created_at", $vkresource->getCreatedAt());
            $this->tag->setDefault("updated_at", $vkresource->getUpdatedAt());
            
        }
    }

    /**
     * Creates a new vkresource
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "index"
            ));
        }

        $vkresource = new Vkresources();

        $vkresource->setVkId($this->request->getPost("vk_id"));
        $vkresource->setName($this->request->getPost("name"));
        $vkresource->setUrl($this->request->getPost("url"));


        if (!$vkresource->save()) {
            foreach ($vkresource->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "new"
            ));
        }

        $this->flash->success("vkresource was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "vkresources",
            "action" => "index"
        ));

    }

    /**
     * Saves a vkresource edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "index"
            ));
        }

        $id = $this->request->getPost("id");

        $vkresource = Vkresources::findFirstByid($id);
        if (!$vkresource) {
            $this->flash->error("vkresource does not exist " . $id);

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "index"
            ));
        }

        $vkresource->setVkId($this->request->getPost("vk_id"));
        $vkresource->setName($this->request->getPost("name"));
        $vkresource->setUrl($this->request->getPost("url"));

        

        if (!$vkresource->save()) {

            foreach ($vkresource->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "edit",
                "params" => array($vkresource->getId())
            ));
        }

        $this->flash->success("vkresource was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "vkresources",
            "action" => "index"
        ));

    }

    /**
     * Deletes a vkresource
     *
     * @param string $id
     */
    public function deleteAction($id)
    {

        $vkresource = Vkresources::findFirstByid($id);
        if (!$vkresource) {
            $this->flash->error("vkresource was not found");

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "index"
            ));
        }

        if (!$vkresource->delete()) {

            foreach ($vkresource->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "vkresources",
                "action" => "search"
            ));
        }

        $this->flash->success("vkresource was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "vkresources",
            "action" => "index"
        ));
    }

}
