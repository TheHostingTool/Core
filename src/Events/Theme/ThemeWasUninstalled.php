<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Events\Theme;

class ThemeWasUninstalled
{
    /**
     * @var string
     */
    protected $theme;

    /**
     * @param string $theme
     */
    public function __construct($theme)
    {
        $this->theme = $theme;
    }
}
