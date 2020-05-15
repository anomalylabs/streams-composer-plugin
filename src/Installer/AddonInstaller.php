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
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Get regex
     *
     * @return string
     */
    public function getRegex()
    {
        $types = implode('|', $this->getTypes());

        return "/^([\w-]+)-({$types})$/";
    }

    /**
     * Gets the path for addon install
     *
     * @param  Composer\Package\PackageInterface $package
     * @return string
     */
    public function getInstallPath(PackageInterface $package)
    {

        $name = $package->getPrettyName();
        $casedNamespace = array_keys($package->getAutoload()['psr-4'])[0];

        $nameParts = explode('/', $name);
        $casedParts = explode('\\', rtrim($casedNamespace, '\\'));

        if (count($nameParts) != 2) {
            throw new \InvalidArgumentException(
                "Invalid package name [{$name}]. Should be in the form of vendor/package"
            );
        }

        if (count($casedParts) <= 1) {
            throw new \InvalidArgumentException(
                "Invalid psr-4 autoload package namespace [{$casedNamespace}]. Should be in the form of Vendor\\Package\\"
            );
        }

        $vendorDir = $this->pascalToSnakeCase($casedParts[0]);
        $packageName = $nameParts[1];

        preg_match($this->getRegex(), $packageName, $match);

        if (count($match) != 3) {
            throw new \InvalidArgumentException(
                "Invalid addon package name [{$name}]. Should be in the form of name-type [{$packageName}]."
            );
        }

        return "core/{$vendorDir}/{$nameParts[1]}";
    }

    /**
     * Converts a PascalCase PHP namespace root into snake case.
     *
     * @param string $string
     * @return string
     */
    private function pascalToSnakeCase(string $string)
    {
        $value = preg_replace('/(.)(?=[A-Z])/u', '$1_', $string);
        return strtolower($value);
    }

    /**
     * Determines whether a package should be processed
     *
     * @param  string
     * @return bool
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
     * @param Composer\Repository\InstalledRepositoryInterface $repository
     * @param Composer\Package\PackageInterface                $initial
     * @param Composer\Package\PackageInterface                $target
     */
    public function update(
        InstalledRepositoryInterface $repository,
        PackageInterface $initial,
        PackageInterface $target
    )
    {
        if (true) {
            parent::update($repository, $initial, $target);
        }
    }
}
