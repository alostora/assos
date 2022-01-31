//react
import React, { useState, useEffect } from 'react';

//translate
import { useTranslation } from "react-i18next";

//component
import { Form } from 'react-bootstrap';
import { axiosInstance } from '../../axios/config';


const ChangePassword = () => {

    //translate
    const { t } = useTranslation();

    const [password, setPassword] = useState("")

    const [confirmPassword, setConfirmPassword] = useState("")

    const [newUserPass, setNewUserPass] = useState({})

    //error message for validate new account
    const [errorMessage, setErrorMessage] = useState(null)


    useEffect(() => {

        setNewUserPass({
            password: password,
            confirmPassword: confirmPassword,
        })

    }, [password, confirmPassword])

    // update profile function
    const updateUserPassword = async (e) => {

        e.preventDefault();

        await axiosInstance({
            method: "post",
            url: `/changePassword`,
            data: newUserPass
        })
            .then((res) => res.data)
            .then((data) => setErrorMessage(data.message))
            .catch((err) => console.error(err));

    }

    return (

        <div className='profile-update d-flex flex-column px-1'>
            <span className='header d-flex mb-3'>{t("Change Password")}</span>

            <form className='d-flex flex-column ' onSubmit={updateUserPassword}>
                <Form.Group className="mb-3" controlId="formPlainPassword">

                    <Form.Label className='paragraph-update'>{t("New Password")}</Form.Label>

                    <Form.Control type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"

                        value={password}
                        onChange={(e) => setPassword(e.target.value)} />

                </Form.Group>

                <Form.Group className="mb-3" controlId="formPlainConfirmPassword">

                    <Form.Label className='paragraph-update'>{t("Confirm New Password")}</Form.Label>

                    <Form.Control type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"

                        value={confirmPassword}
                        onChange={(e) => setConfirmPassword(e.target.value)} />

                </Form.Group>
                {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>}

                <button
                    type="submit"
                    className="btn-save-changes d-flex justify-content-center align-items-center "
                >
                    {t("Save")}
                </button>
            </form>
        </div>
    )

};


export default ChangePassword;
