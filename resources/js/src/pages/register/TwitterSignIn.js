//react
import React from 'react';

//twitter login package
import TwitterLogin from "react-twitter-login";

//icons
import twitterIcon from '../../assets/icons/Login/twitter-icon.png';

// redux
import { useDispatch } from 'react-redux'
import { socialSignUp } from '../../redux/actions/userActions';

//translate 
import { useTranslation } from "react-i18next";


const TwitterSignIn = () => {

    //translate
    const { t } = useTranslation();

    const dispatch = useDispatch()

    
    const authHandler = (err, data) => {
        console.log(err, data);
    };


    return (
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
    )
};

export default TwitterSignIn;
