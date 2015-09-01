<?php namespace Anomaly\StreamsComposerPlugin\Installer;

use Composer\Installer\LibraryInstaller;
use Composer\Package\PackageInterface;
use Composer\Repository\InstalledRepositoryInterface;

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
        'distribution',
        'field_type',
        'extension',
        'module',
        'plugin',
        'block',
        'theme',
    ];

    /**
     * Get types
     *
     * @return string
     */
    public function getTypes()
    {
        return implode('|', $this->types);
    }

    /**
     * Get regex
     *
     * @return string
     */
    public function getRegex()
    {
        $types = $this->getTypes();

        return "/^([a-zA-Z1-9-_]+)-({$types})$/";
    }

    /**
     * {@inheritDoc}
     */
    public function getPackageBasePath(PackageInterface $package)
    {
        $name = $package->getPrettyName();

        $parts = explode('/', $name);

        if (count($parts) != 2) {
            throw new \InvalidArgumentException(
                "Invalid package name [{$name}]. Should be in the form of vendor/package"
            );
        }

        $packageName = $parts[1];

        preg_match($this->getRegex(), $packageName, $match);

        if (count($match) != 3) {
            throw new \InvalidArgumentException(
                "Invalid addon package name [{$name}]. Should be in the form of name-type [{$packageName}]."
            );
        }

        return "core/{$parts[0]}/{$parts[1]}";
    }

    /**
     * {@inheritDoc}
     */
    public function supports($packageType)
    {
        return 'streams-addon' === $packageType;
    }

    /**
     * Update is enabled
     *
     * @return mixed|null
     */
    public function updateIsEnabled()
    {
        return $this->composer->getConfig()->get('streams-composer-plugin-update');
    }

    /**
     * Do NOT update addons
     *
     * @param PackageInterface $initial
     * @param PackageInterface $target
     */
    public function update(InstalledRepositoryInterface $repo, PackageInterface $initial, PackageInterface $target)
    {
        if (true) {
            parent::update($repo, $initial, $target);
        }
    }
}