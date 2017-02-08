<?php

/**
 * @author    TheHostingTool Group
 * @version   2.0.0
 * @package   thehostingtool/core
 * @license   MIT
 */

namespace TheHostingTool\Database;

interface MigrationRepositoryInterface
{
    /**
     * Get the ran migrations for the given extension.
     *
     * @return array
     */
    public function getRan($extension = null);

    /**
     * Log that a migration was run.
     *
     * @param string $file
     * @param string $extension
     * @return void
     */
    public function log($file, $extension = null);

    /**
     * Remove a migration from the log.
     *
     * @param string $file
     * @param string $extension
     * @return void
     */
    public function delete($file, $extension = null);

    /**
     * Create the migration repository data store.
     *
     * @return void
     */
    public function createRepository();

    /**
     * Determine if the migration repository exists.
     *
     * @return bool
     */
    public function repositoryExists();

    /**
     * Set the information source to gather data.
     *
     * @param  string  $name
     * @return void
     */
    public function setSource($name);
}
