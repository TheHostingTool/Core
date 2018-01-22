<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Settings;

interface SettingsRepositoryInterface
{
    public function all();

    public function get($key, $default = null);

    public function set($key, $value);

    public function delete($keyLike);
}
