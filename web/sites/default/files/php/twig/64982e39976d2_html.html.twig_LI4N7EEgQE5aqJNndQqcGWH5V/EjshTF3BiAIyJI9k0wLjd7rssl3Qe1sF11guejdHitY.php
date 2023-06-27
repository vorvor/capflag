<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* themes/flag/html.html.twig */
class __TwigTemplate_0b388a641dbdfa3678dc8a9b7e287dd2 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html>
  <head>
    <link rel=\"stylesheet\" href=\"style.css\">
    <style>
       #map {
        height: 50vh;
        width: 100%;
       }
    </style>
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js\"></script>
  </head>
  <body>
    <div id=\"map\"></div>
    <script async defer
    src=\"https://maps.googleapis.com/maps/api/js?key=AIzaSyAJC8qBk6Q_khSlpv1ZegYxaaGV3TZ7J-o&libraries=geometry&callback=initMap\">
    </script>
    <script>
      var map, infoWindow, polygon;
      var polygons = [];
      var markers = [];
      var pos;

      \$(document).ready(function() {
        \$('#center').click(function() {
          map.setCenter(pos);
        })

        \$('#live').click(function() {

          console.log(\$(this).is(':checked'));
        })
      })

      // Adds a marker to the map and push to the array.
      function addMarker(location, color) {
        var marker = new google.maps.Marker({
          position: location,
          map: map,
          title: 'hey!',
          icon: {
            url: 'https://chart.googleapis.com/chart?chst=d_map_spin&chld=1.15|0|' + color + '|40|_|A',
            scaledSize: new google.maps.Size(20, 34), // marker size
        },
        });


        markers.push(marker);
      }

      // Removes the markers from the map, but keeps them in the array.
      function clearMarkers() {
        setMapOnAll(null);
      }

      // Shows any markers currently in the array.
      function showMarkers() {
        setMapOnAll(map);
      }

      // Deletes all markers in the array by removing references to them.
      function deleteMarkers() {
        clearMarkers();
        markers = [];
      }

      // Sets the map on all markers in the array.
      function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {
          markers[i].setMap(map);
        }
      }

      function removePolygons() {
        for (var i = 0; i < polygons.length; i++) {
          polygons[i].setMap(null);
        }
        polygons = [];  // Clear the array
      }

      function initMap() {
        \$('log').append('y');
        map = new google.maps.Map(\$(\"#map\")[0], {
          center: {lat: -34.397, lng: 150.644},
          zoom: 19
        });

        map.addListener('click', function(event) {
                var clickedLocation = event.latLng;
                \$('#tapped-lat').html(clickedLocation.lat());
                \$('#tapped-lng').html(clickedLocation.lng());
            });
        
        if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    map.setCenter(pos);
                }, function() {
                    handleLocationError(true, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, map.getCenter());
            }

        var paths = [];

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.watchPosition(function(position) {

             

            if (\$('#live').is(':checked')) {

              pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };

              map.setCenter(pos);
            } else {
              pos = {
                lat: \$('#tapped-lat').html(),
                lng: \$('#tapped-lng').html()
              };

              map.setCenter(pos);
            }
            
            console.log(\$('#live').is(':checked'));

            \$.ajax({
              url: '/game.php',
              method: 'POST',
              data: pos,
              success: function(response) {
                console.log(response);

                paths = response.paths;

                // Put the followers sextagon.
                removePolygons();
                polygon = new google.maps.Polygon({
                  paths: paths,
                  map: map,
                  fillColor: \"#FF0000\",
                  fillOpacity: 0.4,
                  strokeColor: \"#FF0000\",
                  strokeOpacity: 0.8,
                });

                polygons.push(polygon);
                polygon.setMap(map);

                // Put markers.
                deleteMarkers();
                // Put all markers.
                response.flags.forEach(function(flag) {
                  console.log(flag);
                  addMarker(flag, 'ff0000');
                });

                // Put visible markers.
                response.flags_inside.forEach(function(flag) {
                  \$('#log').html('Flag found!');
                  addMarker(flag, '00ff00');
                });
                showMarkers();

                \$('#log').html(response.distances);

              },
              error: function(error) {
                // Handle error
                console.log(error);
              }
            });
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          }, {
            enableHighAccuracy: true,
            maximumAge: 0,
            distanceFilter: 1,
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        var infoWindow = new google.maps.InfoWindow({
  content: \"Hello World!\"
});
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>

    <div id=\"monitor\">
      <div id=\"log\"></div>
      <div id=\"buttons\">
        <button id=\"center\">setcenter</button>
        <div>
          <input id=\"live\" type=\"checkbox\" name=\"live\" value=\"live\" CHECKED>
          <label for=\"live\">LIVE</label>
          <div>
            <div id=\"tapped-lat\"></div>
            <div id=\"tapped-lng\"></div>
          </div>
      </div>
      </div>
    </div>
  </body>
</html>
";
    }

    public function getTemplateName()
    {
        return "themes/flag/html.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  39 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "themes/flag/html.html.twig", "/Applications/XAMPP/xamppfiles/htdocs/flag.vr/web/themes/flag/html.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array();
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
