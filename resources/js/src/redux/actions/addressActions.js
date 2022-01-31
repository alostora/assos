
import { GET_ADDRESS_REQUEST, GET_ADDRESS_SUCCESS, GET_ADDRESS_FAIL, CLEAR_ERRORS } from "../constants/Constants"

import { axiosInstance } from "../../axios/config"

export const getAddress = () => async (dispatch) => {

    try {

        dispatch({ type: GET_ADDRESS_REQUEST })

        const { data } = await axiosInstance({
            method: "get",
            url: `/getAddress`

        })

        dispatch({
            type: GET_ADDRESS_SUCCESS,
            payload: data
        })

    }

    catch (error) {
        dispatch({
            type: GET_ADDRESS_FAIL,
            payload: error
        })
    }

}

//clear errors 


export const clearErrors = () => async (dispatch) => {

    dispatch({
        type: CLEAR_ERRORS
    })
}
