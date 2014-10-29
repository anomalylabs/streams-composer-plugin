<?php namespace spec\Anomaly\StreamsComposerPlugin\Installer;

use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use Composer\Package\Package;
use PhpSpec\ObjectBehavior;

/**
 * Class AddonInstallerSpec
 *
 * @author  Osvaldo Brignoni <obrignoni@anomaly.is>
 * @package spec\Streams\ComposerPlugin\Installer
 */
class AddonInstallerSpec extends ObjectBehavior
{

    protected $composerStub;

    function let(IOInterface $io)
    {
        $this->composerStub = new Composer();
        $this->composerStub->setInstallationManager(new InstallationManager());
        $this->composerStub->setConfig(new Config());
        $this->beConstructedWith($io, $this->composerStub);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\StreamsComposerPlugin\Installer\AddonInstaller');
    }

    function it_can_get_regex()
    {
        $this
            ->getRegex()
            ->shouldReturn("/^([a-zA-Z-_]+)-(distribution|field-type|extension|module|block|theme|tag)$/");
    }

    function it_gets_package_base_path()
    {
        $package = new Package('anomaly/foo-bar-module', 1.0, 1.0);
        $this->getPackageBasePath($package)->shouldReturn('core/modules/foo_bar');
    }

    function it_enables_package_update(IOInterface $io)
    {
        $this->composerStub = new Composer();
        $this->composerStub->setInstallationManager(new InstallationManager());
        Config::$defaultConfig['streams-composer-plugin-update'] = true;
        $config = new Config();
        $this->composerStub->setConfig($config);
        $this->beConstructedWith($io, $this->composerStub);
        $this->updateIsEnabled()->shouldBe(true);
    }

    function it_throws_exception_when_package_has_invalid_name()
    {
        $package = new Package('invalid-package-name', 1.0, 1.0);

        $this->shouldThrow(
            new \InvalidArgumentException(
                'Invalid package name. Should be in the form of vendor/package.'
            )
        )->during('getPackageBasePath', array($package));
    }

    function it_throws_exception_when_package_does_not_have_valid_addon_type_suffix()
    {
        $package = new Package('vendor/package-invalid-type', 1.0, 1.0);

        $this->shouldThrow(
            new \InvalidArgumentException(
                'Invalid addon package name. Should be in the form of name-type.'
            )
        )->during('getPackageBasePath', array($package));
    }

}