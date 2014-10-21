<?php namespace spec\Anomaly\StreamsComposerPlugin;

use Composer\Composer;
use Composer\Config;
use Composer\Installer\InstallationManager;
use Composer\IO\IOInterface;
use PhpSpec\ObjectBehavior;

/**
 * Class PluginSpec
 *
 * @author  Osvaldo Brignoni <obrignoni@anomaly.is>
 * @package spec\Streams\ComposerPlugin
 */
class PluginSpec extends ObjectBehavior
{
    protected $composerStub;

    function let()
    {
        $this->composerStub = new Composer();
        $this->composerStub->setInstallationManager(new InstallationManager());
        $this->composerStub->setConfig(new Config());
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Anomaly\StreamsComposerPlugin\Plugin');
    }

    function it_activates(IOInterface $io)
    {
        $this->activate($this->composerStub, $io);
    }

    function it_gets_installer(IOInterface $io)
    {
        $this
            ->getInstaller('AddonInstaller', $this->composerStub, $io)
            ->shouldHaveType('Anomaly\StreamsComposerPlugin\Installer\AddonInstaller');
    }

}
