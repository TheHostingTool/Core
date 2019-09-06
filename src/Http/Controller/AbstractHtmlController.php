<?php

namespace TheHostingTool\Http\Controller;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Twig\Environment;

abstract class AbstractHtmlController extends Controller
{
    /**
     * @var Environment
     */
    protected $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function viewResponse($name, array $context = [])
    {
        $twig = app(Environment::class);
        $rendered = $twig->render($name, $context);

        return Response::create($rendered);
    }

}