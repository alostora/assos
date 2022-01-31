//react
import React, { useEffect, useState, Fragment } from 'react'
import { useTranslation } from "react-i18next";
import { Link, useHistory } from "react-router-dom";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { login, clearErrors } from '../../redux/actions/userActions';

//component
import { Form } from 'react-bootstrap';
import Loader from '../../components/Loader';

//icons
import googleIcon from '../../assets/icons/Login/google-icon.png';
import facebookIcon from '../../assets/icons/Login/facebook-icon.png';
import appleIcon from '../../assets/icons/Login/apple-icon.png';
import twitterIcon from '../../assets/icons/Login/twitter-icon.png';

const Login = () => {

    //translate
    const { t } = useTranslation();

    const history = useHistory();

    const [email, setEmail] = useState("")

    const [password, setPassword] = useState("")

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


    useEffect(() => {

        if (user) {
            localStorage.setItem("api-token", user.api_token || "");
            window.location.reload();
        }

    }, [user])


    const loginHandler = (e) => {

        e.preventDefault();

        dispatch(login(email, password))

    }

    return (

        <Fragment>
            {loading ? <Loader /> :

                <div className='container login-page '>

                    <button
                        className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                        <img src={googleIcon} alt="googleIcon" />
                        <span className='px-3'>{t("Login with Google")}</span>
                    </button>

                    <button
                        className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                        <img src={facebookIcon} alt="googleIcon" />
                        <span className='px-3'>{t("Login with Facebook")}</span>
                    </button>

                    <button
                        className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                        <img src={appleIcon} alt="googleIcon" />
                        <span className='px-3'>{t("Login with Apple")}</span>
                    </button>

                    <button
                        className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3 ">
                        <img src={twitterIcon} alt="googleIcon" />
                        <span className='px-3'>{t("Login with Twitter")}</span>
                    </button>

                    <span className='login-word d-flex justify-content-center mx-auto mt-5 mb-3'>{t("Login")}</span>

                    <form className='d-flex flex-column mx-auto' onSubmit={loginHandler}>

                        <Form.Group className="mb-3" controlId="formPlaintextEmail">

                            <Form.Label className='paragraph-login'>{t("Email address")}</Form.Label>

                            <Form.Control type="email" placeholder="username@website.com" required
                                value={email}
                                onChange={(e) => setEmail(e.target.value)} />

                        </Form.Group>

                        {errorMessage === "error email" && <span className='error-message mb-2'> {t("Incorrect Email")}</span>}

                        <Form.Group className="mb-3" controlId="formPlaintextPassword">

                            <Form.Label className='paragraph-login'>{t("Password")}</Form.Label>

                            <Form.Control type="password" placeholder={t("Password")}

                                value={password} required
                                onChange={(e) => setPassword(e.target.value)} />

                        </Form.Group>

                        {errorMessage === "error password" && <span className='error-message mb-2'>{t("Incorrect Password")}</span>}

                        <Link to="rest-password" className='text-decoration-none'>{t("Forgot your password?")}</Link>

                        <button
                            type="submit"
                            className="btn-login d-flex justify-content-center align-items-center mt-3 mb-4"
                        >
                            {t("Login")}
                        </button>

                        <button
                            className="btn-register d-flex justify-content-center align-items-center px-5 mx-auto"
                            onClick={(event) => {
                                event.preventDefault();
                                return history.push(`/register`)
                            }}>

                            {t("Create a New account")}
                        </button>

                    </form>
                </div>
            }
        </Fragment>
    )
}

export default Login;