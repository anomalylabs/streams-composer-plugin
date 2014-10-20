<?php namespace Streams\ComposerPlugin\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

/**
 * Class AddonInstaller
 *
 * @package Streams\ComposerPlugin\Installer
 */
class AddonInstaller extends LibraryInstaller
{

    /**
     * Addon types
     *
     * @var array
     */
    protected $types = [
        'block',
        'distribution',
        'extension',
        'field-type',
        'module',
        'tag',
        'theme',
    ];

    /**
     * Get regex
     *
     * @return string
     */
    public function getRegex()
    {
        $types = implode('|', $this->types);
        return "/^([a-zA-Z-_]+)-({$types})$/";
    }

    /**
     * {@inheritDoc}
     */
    public function getPackageBasePath(PackageInterface $package)
    {
        $parts = explode('/', $package->getPrettyName());

        if (count($parts) != 2) {
            throw new \InvalidArgumentException(
                'Invalid package name. Should be in the form of vendor/package.'
            );
        }

        $packageName = $parts[1];

        preg_match($this->getRegex(), $packageName, $match);

        if (count($match) != 2) {
            throw new \InvalidArgumentException(
                'Invalid addon package name. Should be in the form of name-type.'
            );
        }

        $type = str_replace('-','_',$match[1]);
        $addon = str_replace('-','_',$match[0]);

        return "addons/shared/{$type}/{$addon}";
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'streams-addon' === $packageType;
    }

} 