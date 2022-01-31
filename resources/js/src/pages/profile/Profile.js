//react
import React, { useEffect, useState, Fragment } from 'react';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";

//images
import profileCover from './../../assets/icons/Profile/profile_cover.png'
import backupImg from './../../assets/icons/Profile/onError_img.jpeg'

//material ui
import CameraAltIcon from '@mui/icons-material/CameraAlt';

//redux
import { useDispatch, useSelector } from 'react-redux';
import { getUserProfile } from '../../redux/actions/userActions';

//componet
import Loader from '../../components/Loader';
import NavProfile from './NavProfile';
import EditProfileModal from './EditProfileModal';
import ProfileInfo from './ProfileInfo';
import ChangePassword from './ChangePassword';
import Address from './address/Address';
import AddAddress from './address/AddAddress';

const Profile = () => {

    // modal edit profile
    const [showModal, setShowModal] = useState(false);

    const closeModalEditProfile = () => setShowModal(false);

    const showModalEditProfile = () => setShowModal(true);

    // fetch from api for search
    const dispatch = useDispatch()

    // user details
    const { loading, user } = useSelector(state => state.auth)


    useEffect(() => {

        //user details
        dispatch(getUserProfile())

    }, [dispatch])


    return (

        <Fragment>
            {loading ? <Loader /> :

                <Router>
                    <div className='d-flex flex-column profile-page'>

                        <img src={profileCover} alt="profileCover" width="100%" height="180px" />

                        <div className='container d-flex flex-column'>

                            <div className='d-flex mb-4 user-img-name'>

                                <div className='user-img'>
                                    <img src={user && user.image} alt='profile-img'
                                        onError={(e) => { e.target.onerror = null; e.target.src = backupImg }} />


                                    <button className="upload-btn-wrapper"
                                        onClick={showModalEditProfile}>

                                        <CameraAltIcon />
                                    </button>

                                    <EditProfileModal show={showModal} handleClose={closeModalEditProfile} />
                                </div>

                                <span className='user-name mx-4 mt-2'>{user && user.name}</span>
                            </div>

                            <div className='row mx-0 mt-4'>

                                <div className="col-lg-4 col-12">
                                    <NavProfile />
                                </div>

                                <div className='col-lg-8 col-12 '>

                                    <Switch>

                                        <Route exact path={"/profile/profile-info"} render={() => <ProfileInfo />} />

                                        <Route exact path={"/profile/profile-info/change-password"} render={() => <ChangePassword />} />

                                        <Route exact path={"/profile/address"} render={() => <Address />} />

                                        <Route exact path={"/profile/address/add-new-address"} render={() => <AddAddress />} />

                                        <Route exact path={"/profile/address/edit-address-:id"} render={() => <AddAddress />} />

                                        <Route exact path={"/profile/orders"} render={() => <h4>orders</h4>} />

                                        <Route exact path={"/profile/payment-methods"} render={() => <h4>payment </h4>} />

                                        <Route exact path={"/profile/notifications"} render={() => <h4>notifi </h4>} />

                                        <Route exact path={"/profile/communication-preferences"} render={() => <h4>communication </h4>} />

                                    </Switch>
                                </div>
                            </div>

                        </div>
                    </div>
                </Router>
            }
        </Fragment>
    )
};

export default Profile;