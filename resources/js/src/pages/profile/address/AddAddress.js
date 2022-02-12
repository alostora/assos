//react
import React, { createContext, useState, useEffect, Fragment } from 'react'

//google map
import CustomGoogleMaps from './CustomGoogleMaps';

//translate
import { useTranslation } from "react-i18next";

// redux
import { useSelector } from 'react-redux'

//react router
import { useParams } from 'react-router-dom';

//component
import { Form } from 'react-bootstrap';
import Loader from '../../../components/Loader';
import { axiosInstance } from '../../../axios/config';

//export context marker
export const LocationMarkerMap = createContext();


const AddAddress = () => {

    //translate
    const { t } = useTranslation();

    //marker value (lat, lng) for data address
    const [marker, setMarker] = useState({ newLat: 29.378586, newLng: 47.990341 })

    //data for address
    const [userName, setUserName] = useState("")

    const [userPhone, setUserPhone] = useState("")

    const [city, setCity] = useState("")

    const [streetName, setStreetName] = useState("")

    const [homeNumber, setHomeNumber] = useState("")

    const [postalCode, setPostalCode] = useState("")

    const [addressDescription, setAddressDescription] = useState("")

    const [mainAddress, setMainAddress] = useState(false)

    const [newAddress, setNewAddress] = useState({})

    //error message for validate new account
    const [errorMessage, setErrorMessage] = useState(null)

    const { loading, user } = useSelector(state => state.auth)


    useEffect(() => {

        setNewAddress({
            name: userName,
            phone: userPhone,
            address: city,
            street: streetName,
            homeNumber: homeNumber,
            postalCode: postalCode,
            addressDESC: addressDescription,
            lat: marker.newLat,
            lng: marker.newLng,
            isMain: mainAddress
        })

    }, [userName, userPhone, city, streetName, homeNumber, postalCode, addressDescription, marker, mainAddress])

    // add address function
    const addAddressHandler = async (e) => {

        e.preventDefault();

        await axiosInstance({
            method: "post",
            url: `/addNewAddress`,
            data: newAddress
        })
            .then((res) => res.data)
            .then(data => setErrorMessage(data.message))

            .catch((err) => console.error(err));

        console.log({ newAddress })
        // const newObj= {...newAddress,id:10}
        // console.log(  newObj)
    }

    const { id: addressId } = useParams();

    const editAddressHandler = (e) => {

        e.preventDefault();

        axiosInstance({
            method: "post",
            url: `/addNewAddress`,
            data: { ...newAddress, id: addressId }
        })
            .then((res) => res.data)
            .then(data => setErrorMessage(data.message))

            .catch((err) => console.error(err));
    }

    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className='profile-address d-flex flex-column px-2'>

                    <LocationMarkerMap.Provider value={{ marker, setMarker }}>

                        <span className='header d-flex mb-2'>{t("Address")}</span>

                        <span className='secondary-header d-flex mb-4'>

                            {addressId ? t("Edit Address") : t("Add New Address")}

                        </span>

                        <div className='map section'>
                            <span className='map-header d-flex mb-3'>{t("Locate on the map")}</span>

                            <CustomGoogleMaps />
                        </div>

                        <form className='row mt-4' onSubmit={addressId ? editAddressHandler : addAddressHandler}>
                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainName">

                                <Form.Label className='paragraph-form-address'>{t("Name")}</Form.Label>

                                <Form.Control type="text" placeholder={t("your name here")} required
                                    value={userName} className='custom-input'
                                    onChange={(e) => setUserName(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainPhone">

                                <Form.Label className='paragraph-form-address'>{t("Phone")}</Form.Label>

                                <Form.Control type="tel" placeholder={t("your phone here")} required
                                    value={userPhone} className='custom-input'
                                    onChange={(e) => setUserPhone(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainCity">

                                <Form.Label className='paragraph-form-address'>{t("City")}</Form.Label>

                                <Form.Control type="text" placeholder={t("City")} required
                                    value={city} className='custom-input'
                                    onChange={(e) => setCity(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainStreetName">

                                <Form.Label className='paragraph-form-address'>{t("Street Name")}</Form.Label>

                                <Form.Control type="text" placeholder={t("Street Name")}
                                    value={streetName} className='custom-input'
                                    onChange={(e) => setStreetName(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainHomeNumber">

                                <Form.Label className='paragraph-form-address'>{t("Home Number")}</Form.Label>

                                <Form.Control type="text" placeholder={t("Home Number")}
                                    value={homeNumber} className='custom-input'
                                    onChange={(e) => setHomeNumber(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainPostalCode">

                                <Form.Label className='paragraph-form-address'>{t("Postal Code")}</Form.Label>

                                <Form.Control type="text" placeholder={t("Postal Code")} required
                                    value={postalCode} className='custom-input'
                                    onChange={(e) => setPostalCode(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-4 col-12" controlId="ControlTextarea">

                                <Form.Label className='paragraph-form-address'>{t("Approximate description of address")}</Form.Label>
                                <Form.Control as="textarea" rows={4}

                                    placeholder={t("Description of address")}
                                    value={addressDescription}
                                    onChange={(e) => setAddressDescription(e.target.value)} />

                            </Form.Group>

                            <Form.Group className="mb-3 col-3 paragraph-form-address" controlId="formBasicCheckbox" >
                                <Form.Check type="checkbox" label={t("Set as main address")}
                                    value={mainAddress}
                                    onChange={(e) => setMainAddress(e.target.checked)} />

                            </Form.Group>

                            {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>}

                            <div className='d-flex justify-content-center mt-3'>

                                <button
                                    type="submit"
                                    className="btn-save-address d-flex justify-content-center align-items-center">
                                    {t("Save Address")}
                                </button>
                            </div>

                        </form>

                    </LocationMarkerMap.Provider>

                </div>
            }
        </Fragment>
    )
};

export default AddAddress;