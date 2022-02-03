//react
import React, { useState, useEffect } from "react";

// redux
import { useDispatch, useSelector } from 'react-redux'
import { updateProfile } from '../../redux/actions/userActions';

//material ui
import CloseIcon from '@mui/icons-material/Close';

//translate
import { useTranslation } from "react-i18next"

//component
import { Modal, Button } from "react-bootstrap";


const EditProfileModal = ({ show, handleClose }) => {

    //translate
    const { t } = useTranslation();

    const [newUserData, setNewUserData] = useState({})

    // fetch from api
    const dispatch = useDispatch()

    const { user } = useSelector(state => state.auth)

    const [newImg, setNewImg] = useState(user && user.image);


    useEffect(() => {

        setNewUserData({
            name: user && user.name,
            phone: user && user.phone,
            email: user && user.email,
            image: newImg,
        })

    }, [user, newImg])

    // update profile function
    const updateProfileImg = (e) => {

        e.preventDefault();

        console.log(newUserData)

        dispatch(updateProfile(newUserData))

    }

    return (

        <Modal show={show} onHide={handleClose} centered>

            <Modal.Header closeButton={false} >

                <Modal.Title>{t("Update Profile Picture")}</Modal.Title>
                <CloseIcon onClick={handleClose} style={{ cursor: "pointer" }} />
            </Modal.Header>

            <Modal.Body>

                <input
                    type="file"
                    accept="image/*"
                    multiple={false}
                    onChange={(e) => setNewImg(e.target.files[0])}
                />
            </Modal.Body>

            <Modal.Footer>

                <Button variant="secondary" onClick={handleClose}>
                    {t("Close")}
                </Button>
                <Button variant="primary" onClick={(e) => {

                    updateProfileImg(e);
                    handleClose();
                }}>
                    {t("upload picture")}
                </Button>
            </Modal.Footer>
        </Modal>

    );
}

export default EditProfileModal;