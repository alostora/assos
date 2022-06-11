//react 
import React from 'react'

import { Modal, Button } from 'react-bootstrap';

import CloseIcon from '@mui/icons-material/Close';

//translate
import { useTranslation } from "react-i18next";

// redux
import { useSelector } from 'react-redux'


const ModalAddress = ({ show, handleClose, text }) => {

    //translate
    const { t } = useTranslation();

    // user address details
    const { loading, address } = useSelector(state => state.address)

    console.log(address, loading)

    return (

        <Modal
            show={show}
            onHide={handleClose}
            centered
            animation
            className='p-2 address-modal'>

            <Modal.Header >
                <Modal.Title>{t("Address")}</Modal.Title>
                <CloseIcon className='mx-2 close-icon-modal' onClick={handleClose} />
            </Modal.Header>

            <Modal.Body>
                
                    {!loading && address && address.map(ad => (

                        <div className='d-flex flex-column address-details pb-2' key={ad.id}>

                            <span>{ad.name}</span>
                            <span>{`${ad.street ? ad.street : ""} - ${ad.address}`}</span>
                            <span>{ad.phone}</span>
                            {ad.isMain ? <span className='pt-1'>{t("Default contact address")} </span> : ""}

                        </div>
                    ))}
                
            </Modal.Body>

            <Modal.Footer>
                <Button variant="secondary" onClick={handleClose}>
                    Close
                </Button>
                <Button variant="primary" onClick={handleClose}>
                    Save Changes
                </Button>
            </Modal.Footer>
        </Modal>

    )
}

export default ModalAddress;