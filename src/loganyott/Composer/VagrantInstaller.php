<?php

namespace loganyott\Composer;

use \Composer\Repository\InstalledRepositoryInterface;
use \Composer\Package\PackageInterface;
use \Composer\Installer\LibraryInstaller;
use \Composer\Util\Filesystem;

class VagrantInstaller extends LibraryInstaller {
  /**
   * {@inheritDoc}
   */
  public function install(InstalledRepositoryInterface $repo, PackageInterface $package) {
    parent::install($repo, $package);
    $vagrantfile = $this->getInstalledPath($package) . '/Vagrantfile';
    if(file_exists($vagrantfile)) {
      $cwd = getcwd();
      Filesystem::ensureDirectoryExists($cwd);
      if(!rename($vagrantfile, $cwd . '/Vagrantfile')) {
        throw new \RuntimeException("\nCouldn't write Vagrantfile to project root.");
      }
    }
  }

  /**
   * {@inheritDoc}
   */
  public function supports($packageType) {
    return 'vagrant-config' === $packageType;
  }
}

