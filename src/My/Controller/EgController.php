<?php
namespace My\Controller;

class EgController
{
    /**
     * Emulate an heavy method
     */
    public function getData($event)
    {
        $count = 0;
        for ($i=0; $i < rand(10000, 99999); $i++) {
            $count = $i;
        }

        return array(
            "hello" => "world",
            "param" => $event->getTarget()->getParam("param", false),
            "param2" => $event->getTarget()->getParam("param2", false)
        );
    }
}
