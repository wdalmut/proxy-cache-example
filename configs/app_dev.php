<?php
return array(
    "router" => array(
        "routes" => array(
            "home" => array(
                "type" => "Literal",
                "options" => array(
                    "route" => "/",
                    'defaults' => array(
                        'renderer' => 'UpCloo\\Renderer\\Jsonp',
                        'controller' => 'exampleController',
                        'action' => 'getData'
                    )
                ),
                'may_terminate' => true,
                "child_routes" => array(
                    "say_hello" => array(
                        "type" => "Segment",
                        "options" => array(
                            "route" => ":param[/:param2]"
                        )
                    )
                )
            )
        )
    ),
    "services" => array(
        "invokables" => array(
            "My\\Controller\\EgController" => "My\\Controller\\EgController"
        ),
        "aliases" => array(
            "exampleController" => "My\\Controller\\EgController"
        )
    ),
    "listeners" => array(
        "404" => array(
            array("My\\Controller\\ErrorController", "error")
        )
    )
);

