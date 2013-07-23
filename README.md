# How to shortcut actions thanks to (object) proxies [cache]

This project is based on [UpCloo Web Framework](https://github.com/wdalmut/upcloo-web-framework)
(a micro-framework written with ZF2 components).

This project wants to highlight how simple and clear is the action of "shortcutting"
thanks to caching systems and object proxies.

Typically when you store your data into a caching system you are doing
something like this:

```
class ...
    public function myAction()
    {
        $cache = // get your manager
        $id = //one way to generate the unique id...
        if (($data = $cache->load($id)) !== false) {
            //Compute your data

            $cache->save($data, $id);
        }

        return $data;
    }
```

As you can see the cache generation is not part of the controller logic,it is
something external that pollutes the action flow with its external structure.

Object proxies are a good way to handle this kind of situations imho...

```
class ...
    public function myAction()
    {
        //Compute your data

        return $data;
    }
```

So? In which way we can store the computed data into the caching system?
In our project we have a DiC or our service locator.
Those components give to the executor, not the real object but its proxy.

```
"services" => array(
    "factories" => array(
        "My\\Controller\\CachedEgController" => function($sl) {
            $objectCache = Zend\Cache\PatternFactory::factory('object', array(
                'object'  => new My\Controller\EgController(),
                'storage' => 'apc',
                "class_cache_methods" => array(
                    "getData"
                )
            ));
            return $objectCache;
        }
        "aliases" => array(
            "exampleController" => "My\\Controller\\CachedEgController"
        )
    )
)
```

The router tries to retrieve the `exampleController` alias from the ServiceManager and
selects and resolves the alias.

During your development or in a controlled environment you can use the common
version:

```
"services" => array(
    "invokables" => array(
        "My\\Controller\\EgController" => "My\\Controller\\EgController"
    ),
    "aliases" => array(
        "exampleController" => "My\\Controller\\EgController"
    )
),
```

## What about page cache?

If we think in terms of jsonp requests we can't store in cache the whole page because
the callback change continuously (random) and the rendered data with it!

    callback_1153513515121("your-data")
    callback_1354657575775("your-data")

The page caching typically stores the whole request results based on
GET, POST and other parameters. Those params are the seed that generates the
cache unique id. The problem is that the callback parameter changes continuously.
That's why the generated cache results are always different.

(no one benefits, there are only drawbacks because we need to persist data
contiuously).

Page caching is very useful in a lot of situation but in this particular one is not our
best choice.

## What about logging?

We always want to log operations and typically we do this at the end of
the process loop if all goes well...

```
$this->events()->attach("finish", function($event){
    $logger = $app->services()->get("logger");
    $logger->info("log with event info...");
});
```

## What about proxies applied to objects inside the controller?

If you think about it, a controller is a facade on its own, because it is a set of all the components
that are part of the system structure. In that sense, you don't need an explicit facade,
you can use the controller.

So what happens if i apply the proxy to the the single components?

```
class ...
    public function myAction()
    {
        $a = $this->get('Proxy\\For\\A');
        $aResult = $a->myMethod(); //cache a

        $b = $this->get('Proxy\\For\\B');
        $bResult = $b->anotherMethod(); //cache b

        //continue and use $aResult and $bResult together

        return $computedData;
    }
```

Now, no one can guarantee that this two cached results will be always compatibles.
This is because the cache expiration of "A" is completely not related to the cache expiration of "B" and thus
strange situations might appear.
In addition it is very hard to discover, replicate and debug particular scenarios
that might occur in production environment.

