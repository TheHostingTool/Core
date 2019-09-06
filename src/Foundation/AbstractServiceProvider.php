<?php

namespace TheHostingTool\Foundation;

use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider
{

    /**
     * @var Application
     */
    protected $app;

    /**
     * AbstractServiceProvider constructor.
     * @param Application $app
     */
    public function __construct($app)
    {
        parent::__construct($app);
    }

}