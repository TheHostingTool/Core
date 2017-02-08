<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Events\Extension;

use TheHostingTool\Extension\Extension;

class ExtensionWasEnabled
{
    /**
     * @var string
     */
    protected $extension;

    /**
     * @param Extension $extension
     */
    public function __construct(Extension $extension)
    {
        $this->extension = $extension;
    }
}
