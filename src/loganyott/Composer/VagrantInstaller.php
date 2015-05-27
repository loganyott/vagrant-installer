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
    $vagrantfile = $this->getInstallPath($package) . '/Vagrantfile';
    if(!file_exists($vagrantfile)) {
      throw new \RuntimeException("\nCouldn't find package's Vagrantfile.");
    }
    if(!($cwd = getcwd())) {
      throw new \RuntimeException("\nCan't access cwd.");
    }
    if(file_exists($cwd . '/Vagrantfile')) {
      // TODO there's a better way to do this, I just haven't found it yet.
      echo "Vagrantfile already exists in project root. Skipping copy...\n";
    }
    else {
      $placeholder = file(dirname(dirname(dirname(dirname(__FILE__)))) . '/Vagrantfile');
      $placeholder[4] = "VAGRANTFILE = " . $vagrantfile . "\n";
      if(!file_put_contents($cwd . '/Vagrantfile', $placeholder)) {
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

