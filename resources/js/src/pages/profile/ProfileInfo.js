//react
import React, { useEffect, useState, Fragment } from 'react'
import { useTranslation } from "react-i18next";
import {  Link } from "react-router-dom";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { updateProfile, clearErrors } from '../../redux/actions/userActions';

//component
import { Form } from 'react-bootstrap';
import Loader from '../../components/Loader';

const ProfileInfo = () => {

    //translate
    const { t } = useTranslation();

    //data for update profile
    const [userName, setUserName] = useState("")

    const [userPhone, setUserPhone] = useState("")

    const [email, setEmail] = useState("")

    const [newUserData, setNewUserData] = useState({})

    //error message for validate new account
    const [errorMessage, setErrorMessage] = useState(null)

    // fetch from api
    const dispatch = useDispatch()

    const { loading, message, user, error } = useSelector(state => state.auth)

    useEffect(() => {

        if (message) {
            setErrorMessage(message)
        }

        if (error) {
            dispatch(clearErrors())
        }

    }, [dispatch, error, message])

    useEffect(() => {

        setNewUserData({
            name: userName,
            phone: userPhone,
            email: email,
        })

    }, [userName, userPhone, email])

    // update profile function
    const updateProfileHandler = (e) => {

        e.preventDefault();

        dispatch(updateProfile(newUserData))

    }

    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className='profile-update d-flex flex-column px-1'>
                    <span className='header d-flex mb-3'>{t("Update Profile")}</span>

                    <form className='d-flex flex-column' onSubmit={updateProfileHandler}>

                        <Form.Group className="mb-3" controlId="formPlainName">

                            <Form.Label className='paragraph-update'>{t("Name")}</Form.Label>

                            <Form.Control type="text" placeholder={user && user.name} required
                                value={userName}
                                onChange={(e) => setUserName(e.target.value)} />

                        </Form.Group>

                        <Form.Group className="mb-3" controlId="formPlainEmail">

                            <Form.Label className='paragraph-update'>{t("Email address")}</Form.Label>

                            <Form.Control type="email" placeholder={user && user.email} required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)} />

                        </Form.Group>

                        <Form.Group className="mb-3" controlId="formPlainPhone">

                            <Form.Label className='paragraph-update'>{t("Phone")}</Form.Label>

                            <Form.Control type="tel" placeholder={user && user.phone} required
                                value={userPhone}
                                onChange={(e) => setUserPhone(e.target.value)} />

                        </Form.Group>

                        {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>}

                        <div className='d-flex justify-content-between align-items-center mt-3 mb-4'>

                            <button
                                type="submit"
                                className="btn-save-changes d-flex justify-content-center align-items-center "
                            >
                                {t("Saving Changes")}
                            </button>
                            <Link
                                to={'/profile/profile-info/change-password'}
                                className="change-pass-link"
                            >
                                {t("Change Password")}
                            </Link>
                        </div>
                    </form>
                </div>
            }
        </Fragment>
    )
};

export default ProfileInfo;