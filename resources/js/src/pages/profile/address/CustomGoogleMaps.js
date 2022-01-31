//react
import React, { useEffect, useState, useCallback, useContext, useRef } from 'react'

//maps
import { GoogleMap, useJsApiLoader, Marker } from '@react-google-maps/api';

//context marker
import { LocationMarkerMap } from './AddAddress';

const CustomGoogleMaps = () => {

    //api key
    const { isLoaded } = useJsApiLoader({
        id: 'google-map-script',
        googleMapsApiKey: "AIzaSyDNimiJ8gebx7HDo9TnKkqauXDPa2bamis"
    })

    // style container map
    const containerStyle = {
        width: '100%',
        height: '180px',
        borderRadius: "20px"

    };

    const [startLocation, setStartLocation] = useState({ lat: 29.378586, lng: 47.990341 })


    const { marker, setMarker } = useContext(LocationMarkerMap)


    //onLoad func
    const mapRef = useRef();

    const onMapLoad = useCallback((map) => {

        mapRef.current = map;
    }, [])


    //onUnmount func 
    // const onUnmount = useCallback(function callback(map) {
    //     setMap(null)
    // }, [])

    //center start map
    const center = {
        lat: startLocation.lat,
        lng: startLocation.lng
    };


    useEffect(() => {

        //get current location
        if ("geolocation" in navigator) {

            navigator.geolocation.getCurrentPosition(position => {
                setStartLocation({ lat: position.coords.latitude, lng: position.coords.longitude })
            })

        } else {
            console.log("Not Available location");
        }

    }, [])


    //function mark on map
    const setNewLocation = (e) => {

        setMarker({
            newLat: e.latLng.lat(),
            newLng: e.latLng.lng()
        })
    }

    return (

        <div className=' d-flex flex-column px-1'>

            {isLoaded ?
                <GoogleMap
                    mapContainerStyle={containerStyle}
                    center={center}
                    zoom={10}
                    onLoad={onMapLoad}
                    //onUnmount={onUnmount}
                    onClick={(e) => setNewLocation(e)}
                >

                    <Marker position={{ lat: marker.newLat, lng: marker.newLng }} />
                </GoogleMap>

                : <></>
            }
        </div>
    )
};

export default CustomGoogleMaps;