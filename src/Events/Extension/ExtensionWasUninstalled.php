<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Events\Extension;

class ExtensionWasUninstalled
{
    /**
     * @var string
     */
    protected $extension;

    /**
     * @param string $extension
     */
    public function __construct($extension)
    {
        $this->extension = $extension;
    }
}
