<?php namespace Anomaly\StreamsComposerPlugin\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;

/**
 * Class AddonInstaller
 *
 * @package Anomaly\StreamsComposerPlugin\Installer
 */
class AddonInstaller extends LibraryInstaller
{

    /**
     * Addon types
     *
     * @var array
     */
    protected $types = [
        'distribution' => 'distributions',
        'field-type'   => 'field_types',
        'extension'    => 'extensions',
        'module'       => 'modules',
        'block'        => 'blocks',
        'theme'        => 'themes',
        'tag'          => 'tags',
    ];

    /**
     * Get regex
     *
     * @return string
     */
    public function getRegex()
    {
        $types = implode('|', array_keys($this->types));

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

        if (count($match) != 3) {
            throw new \InvalidArgumentException(
                'Invalid addon package name. Should be in the form of name-type.'
            );
        }

        $folder = $this->types[$match[2]];
        $addon  = str_replace('-', '_', $match[1]);

        return "core/{$folder}/{$addon}";
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'streams-addon' === $packageType;
    }

    /**
     * Do NOT update addons
     *
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    protected function updateCode(PackageInterface $initial, PackageInterface $target)
    {
    }

}