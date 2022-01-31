//react
import React, { useEffect, Fragment } from 'react';

// redux
import { useDispatch, useSelector } from 'react-redux'
import { getAddress } from './../../../redux/actions/addressActions';

//translate
import { useTranslation } from "react-i18next";

//react router
import { useHistory } from "react-router-dom";

//material ui
import EditOutlinedIcon from '@mui/icons-material/EditOutlined';
import DeleteOutlineOutlinedIcon from '@mui/icons-material/DeleteOutlineOutlined';
import { grey } from '@mui/material/colors';
import HomeIcon from '@mui/icons-material/Home';

//component
import Loader from './../../../components/Loader'
import { axiosInstance } from '../../../axios/config';


const Address = () => {

    //translate
    const { t } = useTranslation();

    //push url
    const history = useHistory();

    // fetch from api for search
    const dispatch = useDispatch()

    // user address details
    const { loading, address } = useSelector(state => state.address)


    useEffect(() => {

        //user address
        dispatch(getAddress())

    }, [dispatch])


    const deleteAddress = async (id) => {

        await axiosInstance({
            method: "get",
            url: `/deleteAddress/${id}`,
        })
            .then((res) => res.status && dispatch(getAddress()))

            .catch((err) => console.error(err));

    }

    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className='profile-address d-flex flex-column px-2'>

                    <div className='d-flex justify-content-between mb-2'>

                        <span className='header '>{t("Address")}</span>

                        {address && address.length > 0 ?

                            <button className='btn-add-new-address'

                                onClick={(e) => {
                                    e.preventDefault();
                                    return history.push("/profile/address/add-new-address")
                                }}>

                                {t("Add New Address")}
                            </button>

                            : <></>

                        }

                    </div>
                    {address && address.length > 0 ? address.map(ad => (

                        <div className='d-flex justify-content-between my-2 one-address p-2 pb-3' key={ad.id}>

                            <div className='d-flex flex-column address-details'>

                                <span>{ad.name}</span>
                                <span>{`${ad.street ? ad.street : ""} - ${ad.address}`}</span>
                                <span>{ad.phone}</span>
                                {ad.isMain ? <span className='pt-2'>{t("Default contact address")} </span> : ""}

                            </div>

                            <div className='d-flex justify-content-between '>

                                <button className='btn-edit mx-3'
                                    onClick={(e) => {
                                        e.preventDefault();
                                        return history.push(`/profile/address/edit-address-${ad.id}`)
                                    }}>

                                    <EditOutlinedIcon sx={{ color: grey[600] }} /></button>
                                <button className='btn-delete'
                                    onClick={() => deleteAddress(ad.id)} >

                                    <DeleteOutlineOutlinedIcon sx={{ color: grey[600] }} /></button>
                            </div>

                        </div>
                    ))
                        :
                        <div className='d-flex flex-column justify-content-center align-items-center p-2 first-address'>

                            <HomeIcon fontSize='large' sx={{ color: grey[600] }} />
                            <span className='my-2'>{t("You don't have any address")}</span>

                            <button className='btn-add-first-address my-2'

                                onClick={(e) => {
                                    e.preventDefault();
                                    return history.push("/profile/address/add-new-address")
                                }}>

                                {t("Add New Address")}
                            </button>
                        </div>
                    }
                </div>

            }
        </Fragment>
    )

};

export default Address;