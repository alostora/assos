//react
import React,{useState} from 'react';

//facebook login package
import FacebookLogin from '@greatsumini/react-facebook-login';

//icons
import facebookIcon from '../../assets/icons/Login/facebook-icon.png';

// redux
import { useDispatch } from 'react-redux'
import { socialSignUp } from '../../redux/actions/userActions';

//translate 
import { useTranslation } from "react-i18next";


const FacebookSignIn = () => {

    //translate
    const { t } = useTranslation();

    const dispatch = useDispatch()


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

    // login with facebook failed
    const failedSignUpFacebook = (response) => {

        console.log("failed facebook login:", response)
    }

    return (
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
    )
};

export default FacebookSignIn;
