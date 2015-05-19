<?php

namespace loganyott\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class VagrantInstallerPlugin implements PluginInterface
{
  public function activate(Composer $composer, IOInterface $io) {
    $installer = new VagrantInstaller($io, $composer);
    $composer->getInstallationManager()->addInstaller($installer);
  }
}

