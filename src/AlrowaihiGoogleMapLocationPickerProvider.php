<?php

namespace Alrowaihi\GoogleMapsLocationPicker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class GoogleMapsLocationPickerProvider extends PackageServiceProvider
{
public function configurePackage(Package $package): void
    {

        $package
            ->name('google-maps-location-picker')
            ->hasConfigFile()
            ->hasViews();
        }
    }