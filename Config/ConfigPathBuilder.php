<?php

/**
 * Config
 *
 * Flexible configuration class, which can load and merge config settings from multiple files and sources.
 *
 * @package   userfrosting/config
 * @link      https://github.com/userfrosting/config
 * @author    Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 * @link      http://blog.madewithlove.be/post/illuminate-config-v5/
 */
namespace UserFrosting\Config;

use UserFrosting\Support\Repository\PathBuilder\PathBuilder;

class ConfigPathBuilder extends PathBuilder
{
    /**
     * Add path to default.php and environment mode file, if specified.
     *
     * @return array
     */
    public function buildPaths($environment = null)
    {
        // Get all paths from the locator that match the uri.
        // Put them in reverse order to allow later files to override earlier files.
        $searchPaths = array_reverse($this->locator->findResources($this->uri, true, true));

        $filePaths = [];
        foreach ($searchPaths as $path) {
            $cleanPath = rtrim($path, '/\\') . '/';

            $filePaths[] = $cleanPath . 'default.php';

            if ($environment) {
                $filePaths[] = $cleanPath . $environment . '.php';
            }
        }

        return $filePaths;
    }
}
