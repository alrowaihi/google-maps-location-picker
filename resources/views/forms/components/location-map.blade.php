<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>How to Add Google Map in Laravel? - ItSolutionStuff.com</title>
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <style type="text/css">
        #map {
            height: 400px;
        }
    </style>
</head>

<body x-data="{'isModalOpen': false}" x-on:keydown.escape="isModalOpen=false">
<script type="text/javascript" >



    document.addEventListener('alpine:init', () => {
        Alpine.store('cords', {
            lat: 10,
            lng: 12,
        });

        Alpine.store('ids', {
            newId: 'mapId',
        });

    });

    function initMap() {
        {{--        {{$getONewId()}}--}}
        let myLatLng = {!! $getLocationCenter() !!} ;
        let map = new google.maps.Map(document.getElementById("map"), {
            zoom: {{ $zoom }},
            center: myLatLng,
        });

        let marker = new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Click to zoom",
            draggable: true,
        });

        map.addListener("click", (event) => {
            myLatLng = {
                lat: event.latLng.lat(),
                lng: event.latLng.lng()
            }

            marker.setPosition( new google.maps.LatLng( event.latLng.lat(), event.latLng.lng() ) );
            Alpine.store('cords').lat = event.latLng.lat();
            Alpine.store('cords').lng = event.latLng.lng();


        });


        marker.addListener("dragend", (event,index) => {
            markerDragEnd(event, index);
            Alpine.store('cords').lat = event.latLng.lat();
            Alpine.store('cords').lng = event.latLng.lng();
        });

        function markerDragEnd(event, index) {
            console.log(event.latLng.lat());
            console.log(event.latLng.lng());
        }

        var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
        map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
        google.maps.event.addListener(searchBox, 'places_changed', function() {
            searchBox.set('map', null);
            let places = searchBox.getPlaces()
            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for (i = 0; place = places[i]; i++) {
                marker.setPosition( place.geometry.location );
                google.maps.event.addListener(marker, 'map_changed', function() {
                    if (!this.getMap()) {
                        this.unbindAll();
                    }
                });
                bounds.extend(place.geometry.location);
            }
            map.fitBounds(bounds);
            searchBox.set('map', map);
            map.setZoom(Math.min(map.getZoom(),15));
        });

        // window.initMap = initMap();
    }

</script>




<x-forms::field-wrapper
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    {{--    :hint-action="$getHintAction()"--}}
    {{--    :hint-color="$getHintColor()"--}}
    {{--    :hint-icon="$getHintIcon()"--}}
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }" x-init="initMap()">
        <!-- Interact with the `state` property in Alpine.js -->
        <div wire:ignore style="display: block; height: 400px;">
            <div x-data="" id="map" @click.prevent="state = {lat:$store.cords.lat,lng:$store.cords.lng}"></div>
            <input index="100" id="pac-input" class="controls" style=" color: #2d3748; border-radius: 7px; " type="text" placeholder="Search Box">
        </div>

    </div>




</x-forms::field-wrapper>

<script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries=places&callback=initMap" async></script>

</body>
</html>
