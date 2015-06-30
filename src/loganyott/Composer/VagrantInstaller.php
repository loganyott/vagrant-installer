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
    if( !( $cwd = getcwd() ) ) {
      throw new \RuntimeException("\nCan't access cwd.");
    }

    $template = dirname(dirname(dirname(dirname(__FILE__)))) . '/Vagrantfile';
    $template = file_get_contents( $template );
    $template = str_replace( "# VAGRANTFILE = ", "VAGRANTFILE = \"$vagrantfile\"", $template );

    if ( false === file_put_contents( $cwd . "/Vagrantfile", $template ) ) {
      throw new \RuntimeException( "\nCouldn't write to Vagrantfile in project root." );
    }
  }

  /**
   * {@inheritDoc}
   */
  public function supports($packageType) {
    return 'vagrant-config' === $packageType;
  }
}

