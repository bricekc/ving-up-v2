import {MapContainer} from "react-leaflet";
import {TileLayer} from "react-leaflet";
import React, {useEffect, useState} from "react";
import {getAllVignes} from "../../services/api/vignes/vignes.jsx";
    function Carte() {
        const [vignes,setVignes]=useState([])
        useEffect(()=>{getAllVignes().then(data=>setVignes(data["hydra:member"]))},[vignes])
        console.log(vignes)
        return(
            <React.Fragment>
            <link
                rel="stylesheet"
                href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
                integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
                crossOrigin=""
            />
            <MapContainer center={[49.258329, 4.031696]} zoom={10} style={{ height: '500px', width:'75%', borderRadius: '10px' ,margin:'20px'}}>
                <TileLayer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
                <marqueur>
                    {vignes.map(vignes => {return <Position du marqueur = {[vignes.latitude,vignes.longitude]}/>})}
                </marqueur>
            </MapContainer>
            </React.Fragment>

        );
    }

export default Carte;