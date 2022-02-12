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

import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { TwitterAuthProvider, signInWithPopup } from "firebase/auth";


const TwitterSignIn = () => {

    //translate
    const { t } = useTranslation();

    //firebase
    const firebaseConfig = {
        apiKey: "AIzaSyDXGZlgYyzF0ZfbLkXpr74uvOQyWQRvnWc",
        authDomain: "molk-7daf8.firebaseapp.com",
        projectId: "molk-7daf8",
        storageBucket: "molk-7daf8.appspot.com",
        messagingSenderId: "688587750859",
        appId: "1:688587750859:web:d1de7f059562ccc3aa4a4e"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);

    const authentication = getAuth(app);

    const dispatch = useDispatch()

    // const authHandler = (err, data) => {
    //     console.log("twitter login", err, data);
    // };

    const signInWithTwitter = () => {
        const provider = new TwitterAuthProvider();
        signInWithPopup(authentication, provider)
            .then((res) => {
                console.log("res", res)
            })
            .catch((err) => {
                console.log("err", err)
            })
    }


    return (
        // <TwitterLogin
        //     authCallback={authHandler}
        //     consumerKey="LTn00fcsgUC7sfC4FkA1JGOd4"
        //     consumerSecret="ksN2GJKsHnfF1fcQoVsShFIG529OqNkDcgQVMxts2JEonerIWK"
        // >
        <button
            className="btn-login__social d-flex justify-content-center align-items-center col-12 mx-auto mb-3"
            onClick={signInWithTwitter}
        >
            <img src={twitterIcon} alt="twitterIcon" />
            <span className='px-3'>{t("Join with Twitter")}</span>

        </button>
        // </TwitterLogin>
    )
};

export default TwitterSignIn;
