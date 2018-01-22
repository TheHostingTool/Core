<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Settings;

use Illuminate\Database\ConnectionInterface;

class DatabaseSettingsRepository implements SettingsRepositoryInterface
{
    protected $database;

    public function __construct(ConnectionInterface $connection)
    {
        $this->database = $connection;
    }

    public function all()
    {
        return $this->database->table('settings')->lists('value', 'key');
    }

    public function get($key, $default = null)
    {
        if (is_null($value = $this->database->table('settings')->where('key', $key)->value('value'))) {
            return $default;
        }

        return $value;
    }

    public function set($key, $value)
    {
        $query = $this->database->table('settings')->where('key', $key);

        $method = $query->exists() ? 'update' : 'insert';

        $query->$method(compact('key', 'value'));
    }

    public function delete($keyLike)
    {
        $this->database->table('settings')->where('key', 'like', $keyLike)->delete();
    }
}
