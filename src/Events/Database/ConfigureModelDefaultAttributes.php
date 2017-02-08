<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Events\Database;

use TheHostingTool\Database\AbstractModel;

class ConfigureModelDefaultAttributes
{
    /**
     * @var AbstractModel
     */
    public $model;

    /**
     * @var array
     */
    public $attributes;

    /**
     * @param AbstractModel $model
     * @param array $attributes
     */
    public function __construct(AbstractModel $model, array &$attributes)
    {
        $this->model = $model;
        $this->attributes = &$attributes;
    }

    /**
     * @param string $model
     * @return bool
     */
    public function isModel($model)
    {
        return $this->model instanceof $model;
    }
}
