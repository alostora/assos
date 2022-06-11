import React from 'react'

import { Modal } from 'react-bootstrap'

import CloseIcon from '@mui/icons-material/Close';

const GeneralModal = ({ show, handleClose, text }) => {


    return (

        <Modal
            show={show}
            onHide={handleClose}
            centered
            animation
            className='p-2 general-modal'>

            <Modal.Body>

                <div className='d-flex justify-content-between align-items-center'>

                    <span className='d-flex justify-content-center align-items-center'>
                        {text}
                    </span>

                    <CloseIcon className='mx-2 close-icon-modal' onClick={handleClose} />
                </div>
            </Modal.Body>

        </Modal>

    );
}

export default GeneralModal;