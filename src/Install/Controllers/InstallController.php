<?php

namespace TheHostingTool\Install\Controllers;

use TheHostingTool\Http\Controller\AbstractHtmlController;

class InstallController extends AbstractHtmlController
{
    public function welcome()
    {
        return $this->viewResponse('install/welcome.html.twig');
    }
}
