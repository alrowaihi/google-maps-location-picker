<?php

namespace Alrowaihi\AlrowaihiGoogleMapLocationPicker;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class AlrowaihiGoogleMapLocationPickerProvider extends PackageServiceProvider
{
public function configurePackage(Package $package): void
    {

        $package
            ->name('google-maps-location-picker')
            ->hasConfigFile()
            ->hasViews();
        }
    }