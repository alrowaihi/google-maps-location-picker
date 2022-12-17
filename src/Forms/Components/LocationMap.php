<?php

namespace App\Forms\Components;

use Exception;
use Filament\Forms\Components\Field;

class LocationMap extends Field
{
    protected string $view = 'forms.components.location-map';

    public float $latitude = 15;
    public float $longitude = 16;
 


    public array $locationCenter = [
        'lat' => 15.356893920277,
        'lng' => 44.173358011179,
    ];

    public int $zoom = 15;

    public function getLocationCenter()
    {
        try {
            return json_encode($this->locationCenter, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
        }
    }

    public function setLocationCenter(array $locationCenter)
    {
        $this->locationCenter = $locationCenter;
    }

    public function setZoom(int $zoom)
    {
        $this->zoom = $zoom;
        return $this->zoom;
    }


    public function getState()
    {
        $state = parent::getState();

        if (is_array($state)) {
            return json_encode($state);
        } else {
            try {
                return $state;
            } catch (Exception $e) {
                return json_encode([
                    'lat' => 0,
                    'lng' => 0
                ]);
            }
        }
    }

}
