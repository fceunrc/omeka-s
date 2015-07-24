<?php
namespace Omeka\Service;

use DirectoryIterator;
use SplFileInfo;
use Zend\Config\Reader\Ini;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class ThemeManager implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    /**
     * @var array All themes
     */
    protected $themes = array();

    /**
     * @var string The current theme
     */
    protected $current;

    /**
     * Validate and register themes.
     */
    public function __construct()
    {
        foreach (new DirectoryIterator(OMEKA_PATH . '/themes') as $dir) {
            if (!$dir->isDir() || $dir->isDot()) {
                continue;
            }
            $iniFile = new SplFileInfo($dir->getPathname() . '/config/theme.ini');
            if (!$iniFile->isReadable() || !$iniFile->isFile()) {
                continue;
            }
            $iniReader = new Ini;
            $ini = $iniReader->fromFile($iniFile->getRealPath());
            if (!isset($ini['name'])) {
                continue;
            }
            $this->themes[$dir->getBasename()] = array('ini' => $ini);
        }
    }

    /**
     * Get all themes.
     *
     * @return array
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * Get a theme by ID.
     *
     * @param string $id
     * @return array|false
     */
    public function getTheme($id)
    {
        return isset($this->themes[$id]) ? $this->themes[$id] : false;
    }

    /**
     * Set the current theme.
     *
     * @param string $id
     */
    public function setCurrent($id)
    {
        $this->current = $id;
    }

    /**
     * Get the current theme.
     *
     * @return string
     */
    public function getCurrent()
    {
        return $this->current;
    }
}