//react
import React, { Fragment, useState } from 'react';

// redux
import { useSelector } from 'react-redux'

//react-router
import { useParams, Link } from "react-router-dom";

//icons material-ui
import HomeOutlinedIcon from '@mui/icons-material/HomeOutlined';
import ArrowBackIosOutlinedIcon from '@mui/icons-material/ArrowBackIosOutlined';
import { grey } from '@mui/material/colors';

//translate
import { useTranslation } from "react-i18next";

//component
import Loader from '../../components/Loader';
import { axiosInstance } from '../../axios/config';
import { Form } from 'react-bootstrap';


const PrivacyPolicies = ({ privacyPolicies }) => {

    //translate
    const { t } = useTranslation();

    const { section_id, section_name } = useParams();

    const selectedSection = privacyPolicies && privacyPolicies.find(section => section.id === Number(section_id))

    //contact us
    const { user } = useSelector(state => state.auth)

    //data for contact
    const [userName, setUserName] = useState("")
    const [userEmail, setUserEmail] = useState("")
    const [message, setMessage] = useState("")

    //error message 
    const [errorMessage, setErrorMessage] = useState("")

    const contactUs = async () => {

        await axiosInstance({
            method: "post",
            url: `/contactUs`,
            data: {
                name: userName,
                email: userEmail,
                message: message
            }
        })
            .then((res) => res.data)
            .then((data) => setErrorMessage(data.message))
            .catch((err) => console.error(err));

    }


    return (

        <Fragment>
            {privacyPolicies && privacyPolicies.length > 0 ?

                <div className='d-flex flex-column container my-4 privacy-policies-page'>

                    <div className="d-flex align-items-center page-names mb-4">

                        <Link to="/" className="text-decoration-none d-flex align-items-center ">
                            <HomeOutlinedIcon style={{ color: grey[500] }} />
                            <span className="page-name mx-1">{t("Home")}</span>
                        </Link>

                        <ArrowBackIosOutlinedIcon fontSize="medium" style={{ color: grey[300] }} />

                        <span className="page-name ">{t(section_name.replace("-", " "))}</span>
                    </div>

                    {selectedSection ?

                        <div className='d-flex flex-column px-2 mt-4'>
                            <h4 className='mb-3'>{selectedSection && selectedSection.privacyTitle}</h4>
                            <p>{selectedSection && selectedSection.privacy}</p>
                        </div>

                        :

                        <div className='d-flex flex-column px-2 mt-4 contact-us-form'>
                            <h3 className='mb-3 header'>{t(section_name.replace("-", " "))}</h3>

                            <form className='row mt-4 form-section' onSubmit={contactUs}>
                                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainName">

                                    <Form.Label className='secondary-header'>{t("Name")}</Form.Label>

                                    <Form.Control type="text" placeholder={user ? user.name : ""} required
                                        value={userName}
                                        onChange={(e) => setUserName(e.target.value)} />

                                </Form.Group>

                                <Form.Group className="mb-3 col-lg-6 col-12" controlId="formPlainEmail">

                                    <Form.Label className='secondary-header'>{t("Email address")}</Form.Label>

                                    <Form.Control type="email" placeholder={user && user.email} required
                                        value={userEmail}
                                        onChange={(e) => setUserEmail(e.target.value)} />

                                </Form.Group>

                                <Form.Group className="mb-4 col-12" controlId="ControlTextarea">

                                    <Form.Label className='secondary-header'>{t("Message")}</Form.Label>
                                    <Form.Control as="textarea" rows={4} required

                                        placeholder={t("Write your message here")}
                                        value={message}
                                        onChange={(e) => setMessage(e.target.value)} />

                                </Form.Group>

                                {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>}

                                <div className='d-flex justify-content-center mt-3'>

                                    <button
                                        type="submit"
                                        className="btn-send-request d-flex justify-content-center align-items-center">
                                        {t("Send")}
                                    </button>
                                </div>
                            </form>
                        </div>
                    }
                </div>

                : <Loader />
            }
        </Fragment>
    )

};

export default PrivacyPolicies;