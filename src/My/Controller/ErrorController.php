<?php
namespace My\Controller;

class ErrorController
{
    public function error($event)
    {
        $event->getTarget()
            ->response()->setContent(json_encode(array("error" => "404")));
    }
}
