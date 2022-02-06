//react
import React from 'react';

//icons
import googleIcon from '../../assets/icons/Login/google-icon.png';

// redux
import { useDispatch } from 'react-redux'
import { socialSignUp } from '../../redux/actions/userActions';

//translate 
import { useTranslation } from "react-i18next";

//google login package
import GoogleLogin from 'react-google-login';


const GoogleSignIn = () => {

  //translate
  const { t } = useTranslation();

  const dispatch = useDispatch()

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

  return (

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
  )
};

export default GoogleSignIn;