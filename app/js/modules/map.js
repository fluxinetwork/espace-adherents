/*======================================================================*\
==========================================================================

                           Google Map

==========================================================================
\*======================================================================*/


var siteURL = 'http://espace-adherents:8888';
var themeURL = siteURL+'/wp-content/themes/espace-adherents';

var map = null;

var windowW = jQuery(window).width();
var bpSmall = '400';

var nbMakers = 0;
var nbShowMakers = 0;
var nbloadedCards = 6;
var gmarkers = [];
var prevCardMapId = null;
var previousMarker = null;
var isOpenMarker = false;

var activateFilters = true;
var filterCat = 'all_cat';
var filterCat2 = 'all_cat';
var is_filtered = false;

var currentInfowindow;

var stylesMap;
var iconsPin;
var iconsActivePin;

var markerCluster = null;
//var cluster_markers = [];

/*var markerShadow;
var iconShadow = {
    url: themeURL+'/app/img/map/marker-shadow.png',
    size: new google.maps.Size(38, 38),
    origin: new google.maps.Point(0, 0),
    anchor: new google.maps.Point(34, 34)
};*/



/*
 * Init Adherents Map
 * - Add a dom container
 * - latlng = new google.maps.LatLng(47.50,2.20);
 * - activateFilters : default = false
 * - mapOptions = { zoom: 6, scrollwheel: false, panControl: true}
 */
function initMap(){

    //console.log('Init Google Map Obj for "Adherents Map"');

    stylesMap=[{featureType:"administrative",elementType:"all",stylers:[{visibility:"on"}]},{featureType:"administrative.country",elementType:"all",stylers:[{visibility:"on"}]},{featureType:"administrative.country",elementType:"labels",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",elementType:"all",stylers:[{visibility:"simplified"}]},{featureType:"administrative.land_parcel",elementType:"all",stylers:[{visibility:"simplified"}]},{featureType:"landscape.natural.terrain",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"poi",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"road",elementType:"all",stylers:[{visibility:"simplified"}]},{featureType:"road",elementType:"geometry",stylers:[{color:"#f7f7f7"}]},{featureType:"road",elementType:"labels.icon",stylers:[{visibility:"simplified"},{hue:"#0500ff"},{saturation:"-100"},{lightness:"45"}]},{featureType:"transit",elementType:"all",stylers:[{visibility:"off"}]},{featureType:"water",elementType:"all",stylers:[{hue:"#007bff"},{visibility:"on"},{lightness:"-9"}]}];

    iconsPin = {
        animation_communication: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#ffffff',
            strokeOpacity: 1,
            strokeWeight: 2,
            fillColor: '#e94ddc',
            fillOpacity: 1,
        },
        developpement_projet: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#ffffff',
            strokeOpacity: 1,
            strokeWeight: 2,
            fillColor: '#4d54e9',
            fillOpacity: 1,
        },
        financement_projet: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#ffffff',
            strokeOpacity: 1,
            strokeWeight: 2,
            fillColor: '#39d6ba',
            fillOpacity: 1,
        },
        structuration_juridique: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#ffffff',
            strokeOpacity: 1,
            strokeWeight: 2,
            fillColor: '#ff9933',
            fillOpacity: 1,
        },
    };

    iconsActivePin = {
        animation_communication: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#e94ddc',
            strokeOpacity: 1,
            strokeWeight: 4,
            fillColor: '#ffffff',
            fillOpacity: 1,
        },
        developpement_projet: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#4d54e9',
            strokeOpacity: 1,
            strokeWeight: 4,
            fillColor: '#ffffff',
            fillOpacity: 1,
        },
        financement_projet: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#39d6ba',
            strokeOpacity: 1,
            strokeWeight: 4,
            fillColor: '#ffffff',
            fillOpacity: 1,
        },
        structuration_juridique: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            strokeColor: '#ff9933',
            strokeOpacity: 1,
            strokeWeight: 4,
            fillColor: '#ffffff',
            fillOpacity: 1,
        },
    };

    var mapContainer = document.getElementById("map");

    var latlng = new google.maps.LatLng(47.50,2.20);

    var mapOptions = {
        zoom: 6,
        scrollwheel: false,
        panControl: true,
        zoomControl: true,
        zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.LEFT_CENTER
        },
        mapTypeControl: false,
        streetViewControl: false,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROAD
    };

    loadGoogleMap(mapContainer, mapOptions);
}
/* Init the google map
 *  mapContainer = DOM element | mapOptions = option array
 */
function loadGoogleMap(mapContainer, mapOptions){

    //console.log('Load Google Map Obj');

    map = new google.maps.Map(mapContainer,mapOptions);
    map.setOptions({styles: stylesMap});

    //mapContainer.className += 'loader';

    loadMarkers(map);
}

/* Load markers by JSON ajax custom request
 * map = Google map object
 * filterCat : default = 'all_cat' / String : cat_slug
 */
function loadMarkers(map){

    //console.log('loadMarkers '+filterCat);

    var str = 'action=get_json_map&tag='+filterCat;

    jQuery.ajax({
        type: 'POST',
        dataType: 'JSON',
        url: ajax_object.ajax_url,
        data: str,
        success: function(data){
            addMakers(map, data);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + ' :: ' + textStatus + ' :: ' + errorThrown);
        }

    });
    return false;
}

function addMakers(map, data){

    //console.log('Add Makers ');

    nbMakers = Object.keys(data).length;

    jQuery.each(data, function(i){

        // If it's an adherent
        if(data[i].postType == 'repertoire'){

            // Slugs
            var tag = data[i].catSlug;

            //  Add markers on the map only on desktop
            //if(windowW >= bpSmall){
                var newLatLng = {lat: Number(data[i].latitude), lng: Number(data[i].longitude)};

                var marker = new google.maps.Marker({
                    position: newLatLng,
                    map: map,
                    title: data[i].title,
                    icon: iconsPin[tag],
                    categorySlug : data[i].catSlug,
                    filiereSlugs : data[i].filiereSlugs,
                    desc : data[i].desc,
                    permalink : data[i].permalink
                });


                var infowindow = new google.maps.InfoWindow({
                    content:'<div class="infowindow__content">'+
                                '<div class="infowindow__content__header">'+
                                    '<p class="infowindow__content__header__type">'+
                                        data[i].catName+
                                        '<br>'+
                                        data[i].filiereNames+
                                    '</p>'+
                                    '<h3 class="infowindow__content__header__title">'+
                                        data[i].title+                                        
                                    '</h3>'+
                                '</div>'+
                                '<div class="infowindow__content__body">'+
                                    '<p class="infowindow__content__body__text">'+
                                    	data[i].desc+
                                    '</p>'+
                                    '<a href="'+data[i].permalink+'" class="infowindow__content__body__link">En savoir plus</a>'+
                                '</div>'+
                            '</div>'
                });

                marker.addListener('click', function(e) {
                    onClickMarker(i,map,marker,tag,e,infowindow);
                });

                // Add class to info window
                google.maps.event.addListener(infowindow, 'domready', function() {

                    $infoBg = jQuery('.gm-style-iw').prev();

                    $infoBg.addClass('infowindow--bg');
                    jQuery('.gm-style-iw').next().addClass('infowindow__close').empty().append('<div class="c-roundBt c-roundBt--dark"><i class="fa fa-times"></i></div>');

                    $infoBg.find('div:eq(0)').addClass('infowindow--bg--shadow__corne')
                    $infoBg.find('div:eq(1)').addClass('infowindow--bg--shadow__bubble');

                    $infoBg.find('div:eq(2)').addClass('infowindow--bg--corne');
                    $infoBg.find('div:eq(2) div:eq(0)').addClass('infowindow--bg--corne__l');
                    $infoBg.find('div:eq(2) div:eq(0)').next().addClass('infowindow--bg--corne__r');

                    $infoBg.find('div:eq(2)').next().addClass('infowindow--bg--bubble');
                });

                gmarkers.push(marker);

                if(i==nbMakers-1 && activateFilters){
                    // Init all filters once if activateFilters = true
                    initFilters(map);
                    activateFilters=false;

                    markerCluster = new MarkerClusterer(map, gmarkers, {imagePath: themeURL+'/app/img/map/m'});
                    markerCluster.setIgnoreHidden(true);
                    markerCluster.setMaxZoom(10);

                    centerMapOnMarkers(map);

                }
            //}
            // Add info card
            /*var markerContent = '<div class="card-map c-'+tag+' hide">';
                    markerContent += '<a href="'+data[i].permalink+'">';
                        markerContent += data[i].title;
                    markerContent += '</a>';

                    markerContent += '<div class="details">';
                       markerContent += 'Des détails..........';
                    markerContent += '</div>';

                    markerContent += '<a class="button" href="'+data[i].permalink+'">Voir la fiche</a>';

                markerContent += '</div>';

            jQuery('.map-cards').append(markerContent);*/

        }

        // End each
   });

}


// Event on click  on a marker
function onClickMarker(index,map,marker,tag,e,infowindow){

    // Modify previous marker
    if(isOpenMarker){
        previousMarker.setIcon(iconsPin[previousTag]);
        previousMarker.setZIndex(1);
        currentInfowindow.close();
    }
    // Change the icon
    marker.setIcon(iconsActivePin[tag]);
    previousMarker = marker;
    previousTag = tag;

    infowindow.open(map, marker);
    currentInfowindow = infowindow;

    marker.setZIndex(10000);
    // center on marker
    map.setCenter( e.latLng );

    // Get the card
    /*if(index != prevCardMapId){
        if(isOpenMarker){
            jQuery('.map-cards .card-map:eq('+prevCardMapId+')').toggleClass('hide');
            setTimeout(function() {
                jQuery('.map-cards .card-map:eq('+index+')').toggleClass('hide');

            }, 220);

        }else{
            jQuery('.map-cards .card-map:eq('+index+')').toggleClass('hide');

        }
    }
    prevCardMapId = index;*/
    isOpenMarker = true;

}

function initFilters(map){

    //console.log('Init filters');
    jQuery('#form-filter-map').on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();
        var count_result = 0;

        if( jQuery('#cat').val() || jQuery('#filiere').val() ){
            is_filtered = true;
            resetMarkers();
            var $form = jQuery('#form-filter-map');

            if( jQuery('#cat').val() ){
	            filterCat = jQuery('#cat').val();
	        }

            if( jQuery('#filiere').val() ){
                filterCat2 = jQuery('#filiere').val();
            }

            jQuery('#form-filter-map').find('.js-reload').removeClass('is-none');

            for (i = 0; i < nbMakers; i++) {

                // If is same category or category not picked
                if ( gmarkers[i].categorySlug == filterCat || filterCat.length === 0 || filterCat == 'all_cat' ){

                    var current_filieres = gmarkers[i].filiereSlugs;
                    var arrayFilieres = current_filieres.split(', ');                  

                    if( jQuery.inArray(filterCat2,arrayFilieres) != -1 || filterCat2.length === 0 || filterCat2 == 'all_cat' ){

    	                gmarkers[i].setVisible(true);
    	                count_result++;

                    }

                }
                else{ // Categories don't match
                    gmarkers[i].setVisible(false);
                }

                // If end loop
                if( i==nbMakers-1 ){
                    markerCluster.repaint();
                    centerMapOnMarkers(map);

                    if(count_result==0) notify('<p class="c-error">Aucun rendez-vous ne correspond.</p>');
                }
            }


        }else{
        	notify('<p class="c-error">Aucun filtre n\'est sélectionné</p>');
        }


    });


    // reset
    jQuery('button[type="reset"]').on('click', function(e){
        e.preventDefault();
        e.stopPropagation();
        resetMarkers();
        if(is_filtered){
            jQuery('#form-filter-map').find('.js-reload').addClass('is-none');
            resetFilters();
            resetMarkers();
            markerCluster.repaint();
            centerMapOnMarkers(map);
            jQuery('#cat option, #dates_rdv option').prop('selected', function() {
                return this.defaultSelected;
            });
            is_filtered = false;
        }
    });

}
/**
* Geolocation
*
*/

jQuery('.js-geoloc').on('click', function(e){
	e.preventDefault();
	if(map){
		initGeoLoc(map);
	}
});

function initGeoLoc(map){
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
          lat: position.coords.latitude,
          lng: position.coords.longitude
        };
        console.log(pos);

        var newLatLng = {lat: position.coords.latitude, lng: position.coords.longitude};

        var marker = new google.maps.Marker({
            position: newLatLng,
            map: map,
            title: "Moi",
            icon: themeURL+'/app/img/map/user_location.png'
        });


        map.setCenter(pos);
        map.setZoom(8);

      }, function() {
        notify('<p class="c-error">Géolocalisation refusée</p>');
      });
    } else {
      notify('<p class="c-error">Votre navigateur ne permet pas la géolocalisation</p>');
    }
}

function resetFilters(){
    for (i = 0; i < gmarkers.length; i++) {
        //if (gmarkers[i].category != filterCat ) {
            gmarkers[i].setVisible(true);
        //}
        if(i == gmarkers.length-1){
            filterCat = 'all_cat';
            //filterDate = 'all_cat';
        }
    }
}


function resetMarkers() {
    if(isOpenMarker){
        // reset icon
        previousMarker.setIcon(iconsPin[previousTag]);

        // close infowindow
        if (isOpenMarker) { currentInfowindow.close();}
        isOpenMarker = false;
        // reset card
        //jQuery('.map-cards .card-map:eq('+prevCardMapId+')').toggleClass('hide');
        //prevCardMapId = null;
    }
}


function centerMapOnMarkers(map){
    nbShowMakers = nbMakers;
    var LatLngList = new Array ();
    var bounds = new google.maps.LatLngBounds ();
    // Bind all marker's positions
    for (i = 0; i < gmarkers.length; i++) {
        if(gmarkers[i].visible)
        LatLngList.push(gmarkers[i].getPosition());
        else
        nbShowMakers--;
    }
    //  And increase the bounds to take this point
    for (var j = 0, LtLgLen = LatLngList.length; j < LtLgLen; j++) {
        bounds.extend (LatLngList[j]);
    }

    if(nbShowMakers >= 3){
        map.fitBounds (bounds);
    }else if(nbShowMakers == 2){
        map.setZoom(6);
        map.setCenter(bounds.getCenter());
    }else if(nbShowMakers == 1){
        map.setZoom(7);
        map.setCenter(bounds.getCenter());
    }
}

function removeMarkers() {
    //console.log('Remove All Markers');
     for(i=0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}

/*
 * Reload map page on resize
 *
 */
function reloadCurrentPage(){
    if(lastWindowW <= bpSmall && windowW >= bpSmall && jQuery('#map').length == 1){
        location.reload(true);
        lastWindowW = windowW;
    }
}



