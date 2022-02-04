//react
import React, { useEffect, useState, Fragment, Children } from 'react'
import { useTranslation } from "react-i18next";
import { useHistory } from "react-router-dom";
import GoogleLogin from 'react-google-login';
import FacebookLogin from '@greatsumini/react-facebook-login';
import TwitterLogin from "react-twitter-login";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { register, clearErrors, socialSignUp } from '../../redux/actions/userActions';

//component
import { Form } from 'react-bootstrap';
import Loader from '../../components/Loader';

//icons
import googleIcon from '../../assets/icons/Login/google-icon.png';
import facebookIcon from '../../assets/icons/Login/facebook-icon.png';
import appleIcon from '../../assets/icons/Login/apple-icon.png';
import twitterIcon from '../../assets/icons/Login/twitter-icon.png';


const Register = () => {

    //translate
    const { t } = useTranslation();

    const history = useHistory();

    //data for register
    const [userName, setUserName] = useState("")

    const [userPhone, setUserPhone] = useState("")

    const [email, setEmail] = useState("")

    const [password, setPassword] = useState("")

    const [confirmPassword, setConfirmPassword] = useState("")

    const [newUserData, setNewUserData] = useState({})
    ////////////////////////////////////////////////////////////

    //error message for validate new account
    const [errorMessage, setErrorMessage] = useState(null)

    // fetch from api
    const dispatch = useDispatch()

    const { loading, isAuthenticated, message, user, error } = useSelector(state => state.auth)


    useEffect(() => {

        if (isAuthenticated) {
            return history.push("/molk")
        }
        if (message) {
            setErrorMessage(message)
        }

        if (error) {
            dispatch(clearErrors())
        }
    }, [dispatch, isAuthenticated, error, history, message])


    //set api token in localStorage after success register
    useEffect(() => {

        if (user) {
            localStorage.setItem("api-token", user.api_token || "")
            window.location.reload();
        }

    }, [user])

    //data for request new user account
    useEffect(() => {

        setNewUserData({
            name: userName,
            phone: userPhone,
            email: email,
            password: password,
            confirmPassword: confirmPassword,
        })

    }, [userName, userPhone, email, password, confirmPassword])


    // register function
    const registerHandler = (e) => {

        e.preventDefault();

        dispatch(register(newUserData))

    }
    //////////////////////////////////////////////////////////

    // signUp with google success
    const signUpSocialGoogle = (response) => {

        dispatch(socialSignUp({
            name: response && response.profileObj && response.profileObj.name,
            email: response && response.profileObj && response.profileObj.email,
            image: response && response.profileObj && response.profileObj.imageUrl,
            socialType: "google",
            socialToken: response && response.googleId,
        }))

        console.log(response)
    }

    // signUp with google failed
    const failedSignUpGoogle = (response) => {

        console.log("failed google login:", response)
    }
    ////////////////////////////////////////////////////////////////////

    const [facebookToken, setFacebookToken] = useState("")

    // login with facebook success first
    const signUpSocialFacebook = (response) => {

        setFacebookToken(response && response.userID)
        console.log(response)

    }

    // get profile facebook success second
    const getProfileSignUpFacebook = (response) => {

        dispatch(socialSignUp({
            name: response && response.name,
            email: response && response.email,
            image: response && response.picture && response.picture.data && response.picture.data.url,
            socialType: "facebook",
            socialToken: facebookToken,
        }))

        console.log(response)

    }

    // signUp with facebook failed
    const failedSignUpFacebook = (response) => {

        console.log("failed facebook login:", response)

    }

    ///////////////////////////////////////////////////////////

    const authHandler = (err, data) => {
        console.log(err, data);
    };

    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className='container register-page '>

                    <GoogleLogin
                        clientId="952820575139-e000s6j5uovffn669dkgs25p54akrpjo.apps.googleusercontent.com"

                        render={(renderProps) => (
                            <button
                                className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 "
                                onClick={renderProps.onClick}
                            >
                                <img src={googleIcon} alt="googleIcon" />
                                <span className='px-3'>{t("Join with Google")}</span>
                            </button>
                        )}
                        onSuccess={signUpSocialGoogle}
                        onFailure={failedSignUpGoogle}
                        // isSignedIn={true}
                        cookiePolicy={'single_host_origin'}
                    />

                    <FacebookLogin
                        appId="603876184006823"
                        onSuccess={signUpSocialFacebook}
                        onFail={failedSignUpFacebook}
                        onProfileSuccess={getProfileSignUpFacebook}
                        render={({ onClick }) => (
                            <button
                                className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 "
                                onClick={onClick}
                            >
                                <img src={facebookIcon} alt="facebookIcon" />
                                <span className='px-3'>{t("Join with Facebook")}</span>
                            </button>
                        )}
                    />

                    <button
                        className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                        <img src={appleIcon} alt="appleIcon" />
                        <span className='px-3'>{t("Join with Apple")}</span>
                    </button>

                    <TwitterLogin
                        authCallback={authHandler}
                        consumerKey="LTn00fcsgUC7sfC4FkA1JGOd4"
                        consumerSecret="ksN2GJKsHnfF1fcQoVsShFIG529OqNkDcgQVMxts2JEonerIWK"
                    >
                        <button
                            className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                            <img src={twitterIcon} alt="twitterIcon" />
                            <span className='px-3'>{t("Join with Twitter")}</span>

                        </button>
                    </TwitterLogin>

                    <span className='register-word d-flex justify-content-center mx-auto mt-5 mb-3'>{t("Create a New account")}</span>

                    <form className='d-flex flex-column mx-auto' onSubmit={registerHandler}>

                        <Form.Group className="mb-3" controlId="formPlainName">

                            <Form.Label className='paragraph-register'>{t("Name")}</Form.Label>

                            <Form.Control type="text" placeholder={t("your name here")} required
                                value={userName}
                                onChange={(e) => setUserName(e.target.value)} />

                        </Form.Group>


                        <Form.Group className="mb-3" controlId="formPlainPhone">

                            <Form.Label className='paragraph-register'>{t("Phone")}</Form.Label>

                            <Form.Control type="tel" placeholder={t("your phone here")} required
                                value={userPhone}
                                onChange={(e) => setUserPhone(e.target.value)} />

                        </Form.Group>


                        <Form.Group className="mb-3" controlId="formPlainEmail">

                            <Form.Label className='paragraph-register'>{t("Email address")}</Form.Label>

                            <Form.Control type="email" placeholder="username@website.com" required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)} />

                        </Form.Group>

                        <Form.Group className="mb-3" controlId="formPlainPassword">

                            <Form.Label className='paragraph-register'>{t("Password")}</Form.Label>

                            <Form.Control type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"

                                value={password}
                                onChange={(e) => setPassword(e.target.value)} />

                        </Form.Group>

                        <Form.Group className="mb-3" controlId="formPlainConfirmPassword">

                            <Form.Label className='paragraph-register'>{t("Confirm Password")}</Form.Label>

                            <Form.Control type="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"

                                value={confirmPassword}
                                onChange={(e) => setConfirmPassword(e.target.value)} />

                        </Form.Group>
                        {errorMessage && <span className='error-message mb-2'> {errorMessage}</span>}


                        <button
                            type="submit"
                            className="btn-register d-flex justify-content-center align-items-center mx-auto mt-3 mb-4 w-100"
                        >
                            {t("Create a New account")}
                        </button>

                        <button
                            className="btn-login d-flex justify-content-center align-items-center px-5 mx-auto "
                            onClick={(event) => {
                                event.preventDefault();
                                return history.push(`/login`)
                            }}>

                            {t("Login")}
                        </button>
                    </form>

                </div>
            }
        </Fragment>
    )
}

export default Register;